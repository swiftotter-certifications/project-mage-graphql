# GraphQL in Magento Training Project

The code in this project is meant to be used with the SwiftOtter training course for GraphQL in Magento.

## Compatibility

This project has been specifically tested on **Magento Open Source 2.4.5**.

## Installation

This project is meant to be used with an _existing_ Magento installation.

In your Magento root directory, create a `training-modules` directory and clone this project into
`training-modules/project-mage-graphql`:

```
git clone git@github.com:swiftotter-certifications/project-mage-graphql.git training-modules/project-mage-graphql
```

Then set up a local Composer repository:

```
composer config repositories.training-mage-graphql '{"type": "path", "url": "training-modules/project-mage-graphql/src/*", "options": {"symlink": true}}'
```

## Example modules

Packages in `src` starting with `example-` are not meant to be directly installed but serve as example code for the
exercises in the course, or else are intended to be copied into `app/code` as directed by the course instructions.

## Prerequisites

Some packages in `src` are necessary prerequisites to the coding exercises in the course and should be installed from the
local Composer repository when indicated in the course instructions.
