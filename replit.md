# HK Wholesale site on Replit

This repository is a Hugo site using the local `themes/faster` theme. The `public/` directory contains generated site output; edit `content/`, `hugo.yaml`, or the theme instead.

## Run

Use the **Run** button to start the **Start application** workflow. It runs:

```sh
hugo server --bind 0.0.0.0 --port 5000 --baseURL / --renderToMemory --disableFastRender
```

The site appears in Replit's web preview on port 5000. Hugo is installed through the Replit Nix package configuration in `.replit`. No environment secrets are required to view the site. To build static output manually, run `hugo`.

## Known limitation

The Contact page's form posts to a PHP endpoint provided by the theme. Hugo serves static content only, so this form cannot send messages through the preview. The embedded third-party chat widget is separate from the form.