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
