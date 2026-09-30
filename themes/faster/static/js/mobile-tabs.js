(function () {
    "use strict";

    var tabs = document.querySelectorAll(".mobile-tab");

    function updateCurrentTab() {
        var path = window.location.pathname.replace(/\/?$/, "/");
        var currentTab = null;

        if (path === "/") {
            currentTab = "home";
        } else if (path.indexOf("/services/") !== -1) {
            currentTab = window.location.hash === "#logistics-services" ? "logistics" : "products";
        } else if (path.indexOf("/contact/") !== -1) {
            currentTab = "contact";
        }

        tabs.forEach(function (tab) {
            if (tab.dataset.mobileTab === currentTab) {
                tab.setAttribute("aria-current", "page");
            } else {
                tab.removeAttribute("aria-current");
            }
        });
    }

    updateCurrentTab();
    window.addEventListener("hashchange", updateCurrentTab);

    var mobileViewport = window.matchMedia("(max-width: 991.98px)");
    var chatObserver = new MutationObserver(dismissMobileChatPrompt);

    function dismissMobileChatPrompt() {
        document.querySelectorAll("chat-widget").forEach(function (widget) {
            if (!widget.shadowRoot) {
                return;
            }

            chatObserver.observe(widget.shadowRoot, { childList: true, subtree: true });
            if (!mobileViewport.matches) {
                return;
            }

            var closePrompt = widget.shadowRoot.querySelector('button[aria-label="Close prompt"]');
            if (closePrompt) {
                closePrompt.click();
                chatObserver.disconnect();
            }
        });
    }

    chatObserver.observe(document.documentElement, { childList: true, subtree: true });
    if (mobileViewport.addEventListener) {
        mobileViewport.addEventListener("change", dismissMobileChatPrompt);
    } else {
        mobileViewport.addListener(dismissMobileChatPrompt);
    }
    dismissMobileChatPrompt();
})();
