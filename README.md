# ROOT File Viewer

A lightweight, browser-based viewer for [ROOT](https://root.cern/) files, designed to run on **CERN personal webpages** (or any web server with PHP support). It requires no local installation of ROOT, no Python, and no command-line tools on the visitor's side — just a web browser.

---

## What is this?

Physicists working at CERN often produce ROOT files containing histograms, canvases, and other analysis outputs. Sharing these results with collaborators normally requires everyone to have ROOT installed. This project removes that barrier.

**ROOT File Viewer** works by:
1. Scanning the directory on the server for `.root` files (using a small PHP script).
2. Opening and rendering those files **entirely in the browser** using [jsROOT](https://root.cern/js/) — CERN's official JavaScript library for ROOT file rendering.

The result is a clean, interactive web page that displays your histograms and canvases automatically, grouped by type (TCanvas, TH1, TH2), without anyone needing ROOT installed.

---

## Features

- **Zero client-side setup** — works in any modern browser.
- **Automatic discovery** — all `.root` files in the served directory are found and loaded automatically.
- **Subdirectory navigation** — browse into subfolders (both filesystem directories and ROOT internal `TDirectory`/`TDirectoryFile` objects) via clickable buttons.
- **Configurable search depth** — choose how many levels of ROOT-internal directories to scan and display at once.
- **Search / filter** — type a name or glob pattern (e.g. `*pt*`, `jet_?`) to instantly filter the displayed objects.
- **Drag-to-reorder** — drag any plot card to rearrange the display order within its section.
- **Interactive plots** — all jsROOT interactivity is preserved: zoom, pan, color-scale adjustment, and more.
- **Grouped display** — objects are automatically sorted into TCanvas, TH1, and TH2 sections.
- **Breadcrumb trail** — always shows where you are inside a ROOT file's directory structure.

---

## How to install (main branch)

### Prerequisites

Your web server must support **PHP** (version 7 or later). On CERN's lxplus web hosting (`/eos/user/<initial>/<username>/www/` served at `https://cern.ch/user/<username>/`), PHP is available by default.

No ROOT, Python, or any other dependency needs to be installed — everything else is loaded from CDN at page-load time.

### Steps

1. **Download the viewer files.**

   Clone or download the repository and copy its contents into the directory on your web server where your `.root` files live:

   ```bash
   git clone -b main https://github.com/GNiramay/RootFileViewer.git
   ```

   Or download the ZIP from the [main branch](https://github.com/GNiramay/RootFileViewer/archive/refs/heads/main.zip) and extract it.

2. **Place `index.html` and `files.php` next to your ROOT files.**

   Your directory should look like this:

   ```
   your-web-directory/
   ├── index.html      ← the viewer page
   ├── files.php       ← scans the directory for .root files
   ├── myanalysis.root
   ├── histograms.root
   └── subdir/
       └── more_results.root
   ```

   Both `index.html` and `files.php` must be in the **same directory** as the `.root` files you want to display.

3. **Open the page in a browser.**

   Navigate to that directory's URL, for example:

   ```
   https://cern.ch/user/yourusername/myanalysis/
   ```

   The viewer will automatically find all `.root` files in the directory and render their contents.

### Deploying to subdirectories

If you have ROOT files in multiple subdirectories, simply copy `index.html` and `files.php` into each one. The navigation buttons at the top of the page let visitors move between directories.

---

## Usage tips

- **Search bar** — type any part of a histogram name to filter what's shown. Glob wildcards (`*`, `?`) are supported: e.g. `*eta*` or `jet_?`.
- **Search depth** — use the depth control next to the search bar to automatically expand ROOT-internal subdirectories. Set it to `1` to show objects one level deep inside `TDirectory` objects, `2` for two levels, etc. The default is `0` (top level only).
- **Subdirectory buttons** — appear at the top when subdirectories (filesystem or ROOT-internal) are found. Click to navigate into them. Use the **Back** button or **Parent Directory** to go back.
- **Drag handles** (`⋮⋮`) — appear at the top of each plot card. Drag them to reorder plots within a section.
- **Interactive plots** — scroll to zoom, right-click for ROOT options, hover for bin values.

---

## Reporting bugs and contributing

Bug reports and feature requests are very welcome! Please [open an issue](https://github.com/GNiramay/RootFileViewer/issues) on GitHub describing:

- What you were trying to do.
- What you expected to happen.
- What actually happened (include any browser console errors if possible — open them with F12 → Console).
- Your browser and OS.

If you would like to contribute to the project, you are welcome to join the developer team! Reach out via the [GitHub issues page](https://github.com/GNiramay/RootFileViewer/issues) and introduce yourself.

---

## About the developer

This project was developed by a PhD candidate at Texas Tech University conducting research with the CMS detector at CERN. The viewer grew out of a practical need to interactively explore complex overlay and stack plots directly in the browser, without having to modify and re-run analysis scripts every time.

---

## Technical notes (for the curious)

- **`files.php`** — a tiny PHP script that lists `.root` files and subdirectories in the current directory and returns them as JSON. The viewer's JavaScript fetches this on page load.
- **`index.html`** — the entire viewer application. It imports [jsROOT](https://root.cern/js/latest/) directly from CERN's servers as an ES6 module, so no local copy is needed. [SortableJS](https://sortablejs.github.io/Sortable/) is loaded from a CDN for drag-and-drop reordering.
- ROOT files never leave your server — the browser fetches them directly from the URL where they are hosted and renders them locally using jsROOT.
