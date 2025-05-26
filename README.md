# Jetpack Stats Script Deprioritization #

Contributors: [westonruter](https://profile.wordpress.org/westonruter)  
Tested up to: 6.8  
Stable tag:   0.1.0  
License:      [GPLv2](https://www.gnu.org/licenses/gpl-2.0.html) or later  
Tags:         performance

## Description ##

This plugin deprioritizes the loading of the [Stats](https://jetpack.com/support/jetpack-stats/) script in the [Jetpack](https://wordpress.org/plugins/google-site-kit/) plugin to attempt to reduce network contention with loading resources in the critical rendering path (e.g. the LCP element image). It deprioritizes the script by:

1. Adding `fetchpriority="low"` to the `script` tag.
2. Removing the `dns-prefetch` for `stats.wp.com`.

This does not primarily benefit Chrome since that browser already gives `async` scripts a priority of low. It does benefit Safari and Firefox, however, since they have a default medium/normal priority.

For an example of the performance impact for this change, see the [Site Kit GTag Script Deprioritization](https://github.com/westonruter/google-site-kit-gtag-script-deprioritization) plugin.

I've [proposed](https://github.com/Automattic/jetpack/issues/43631) these changes for inclusion in Jetpack.

## Installation ##

1. Download the plugin [ZIP from GitHub](https://github.com/westonruter/jetpack-stats-script-deprioritization/archive/refs/heads/main.zip) or if you have a local clone of the repo run `npm run plugin-zip`.
2. Visit **Plugins > Add New Plugin** in the WordPress Admin.
3. Click **Upload Plugin**.
4. Select the `jetpack-stats-script-deprioritization.zip` file on your system from step 1 and click **Install Now**.
5. Click the **Activate Plugin** button.

You may also install and update via [Git Updater](https://git-updater.com/).

## Changelog ##

### 0.1.0 ###

* Initial release.
