# Tify IIIF Viewer for Omeka S

This is an Omeka S module that integrates the [Tify IIIF viewer](https://github.com/tify-iiif-viewer/tify) into Omeka S.

## Requirements

- Omeka S 4.0 or higher
- (Optional) [IIIF Presentation](https://omeka.org/s/modules/IiifPresentation/) module - recommended for serving your own IIIF manifests

## Installation

### Option 1: Git Clone

```bash
cd /path/to/omeka-s/modules
git clone https://github.com/indic-archive/omeka-s-tify.git Tify
```

> **Note:** The directory must be named `Tify` (not `omeka-s-tify`) to match the PHP namespace. The clone command above handles this automatically by specifying `Tify` as the target directory.

Then install via the Omeka S admin panel under **Modules**.

### Option 2: Download ZIP

1. Download the ZIP from GitHub: **Code** → **Download ZIP**
2. Extract the archive
3. **Important:** Rename the extracted folder from `omeka-s-tify-main` to `Tify`
4. Move the `Tify` folder to your Omeka S `modules/` directory
5. Log in to the Omeka S admin panel
6. Navigate to **Modules** and click **Install** next to Tify

## Configuration

After installation, go to **Modules** → **Tify** → **Configure** to customize viewer settings.

### Full text fonts

Readers can switch the font of the **Full text** tab with a **Select Font** dropdown at the top of the panel. Only the transcribed text changes; the rest of the viewer keeps its font. The choice is remembered in the reader's browser.

The available fonts are set in **Full text fonts**, one per line:

```
Label | CSS font-family | URL
```

- **Label** is shown in the dropdown. The first line is the default font.
- **CSS font-family** is applied to the text, e.g. `'Noto Serif Malayalam', serif`.
- **URL** (optional) is either a stylesheet that defines the font, such as a Google Fonts link, or a font file (`.woff2`, `.woff`, `.ttf`, `.otf`), for which an `@font-face` rule is generated. It may be absolute or start with `/` for a file on the same site.

With fewer than two lines, no dropdown is shown. The default list offers Manjari and Noto Serif Malayalam from Google Fonts, and **Thumba**, which is bundled with the module (`asset/fonts/THUMBA.ttf`).

Thumba is by C-DIT, Government of Kerala, from [kerala.gov.in](https://kerala.gov.in/assets/malayalamfonts/font/THUMBA.ttf). Per the font's own licence notice, its OpenType feature table is under the SIL Open Font License 1.0 and its glyphs are © C-DIT, Government of Kerala 2022, all rights reserved. It is bundled rather than linked because kerala.gov.in's bot check blocks cross-site font requests. Its default entry uses a site-root path, so it assumes the module is installed as `modules/Tify` with Omeka S at the site root.
