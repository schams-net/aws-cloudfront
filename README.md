# Amazon CloudFront Integration

This [TYPO3](https://typo3.org) extension integrates [Amazon CloudFront](https://aws.amazon.com/cloudfront/) into the enterprise content management system TYPO3. Amazon CloudFront is a global content delivery network (CDN) service built for high performance, security, and developer convenience.

The Amazon CloudFront Integration for TYPO3 lets backend users (e.g. editors) trigger a CDN invalidation (clear the CDN cache) on a page-by-page basis.

## Key Features

- Excellent integration into the TYPO3 backend UI.
- Supports multiple sites with different CloudFront distributions per TYPO3 instance.
- Invalidations are manipulable through [PSR-14 events](https://www.php-fig.org/psr/psr-14/).

➤ Read the (not yet created) documentation for further details and all features.

## Documentation

*(work in progress)*

## Installation

The TYPO3 extension “Amazon CloudFront” is available as a [Composer](https://getcomposer.org/) package from [Packagist](https://packagist.org/packages/t3rrific/aws-cloudfront).

```bash
composer require t3rrific/aws-cloudfront
```

## Git Branches, Versions, and Compatibility

The TYPO3 extension Amazon CloudFront follows [semantic versioning](https://semver.org/).

| Major version: | Git branch:                                                            | Status:                  | TYPO3 compatibility: |
|---------------:|:----------------------------------------------------------------------:|:-------------------------|:---------------------|
|           v1.x | [typo3v11](https://github.com/t3rrific/aws-cloudfront/tree/typo3v11)   | legacy, still maintained | TYPO3 v11 LTS        |
|           v2.x | [main](https://github.com/t3rrific/aws-cloudfront/tree/main)           | **stable**               | TYPO3 v12 LTS        |
|           v3.x | n/a                                                                    | *planned*                | TYPO3 v13            |

## Contribution

Please report issues or submit feature requests and pull requests through the [Git repository at GitHub](https://github.com/typo3-on-aws/aws-cloudfront).

## License

(c) 2023 Michael Schams <[schams.net](https://schams.net) | [t3rrific.com](https://t3rrific.com)>, all rights reserved

This program is free software. You can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program. If not, see <https://www.gnu.org/licenses/>.

➤ Read more: [The GNU General Public License](https://www.gnu.org/licenses/gpl-3.0.html).
