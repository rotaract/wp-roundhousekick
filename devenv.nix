# SPDX-FileCopyrightText: 2025 Benno Bielmeier
#
# SPDX-License-Identifier: CC0-1.0

{
  pkgs,
  lib,
  config,
  inputs,
  ...
}:

{
  packages = builtins.attrValues {
    inherit (pkgs) reuse yamllint editorconfig-checker;
  };

  languages = {
    javascript = {
      enable = true;
      bun.enable = true;
    };
    php = {
      enable = true;
      # version = "8.4";
    };
  };

  pre-commit.hooks.reuse.enable = true;
}
