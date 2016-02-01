This is currently unusable and untested.

# BadBehavior

This is an object-oriented rewrite of BadBehavior. 

## License
As with the original, is is licensed under LGPL-3.0.
I don't really feel like worrying about the license, so if there is another compatible license and you want it in that,
I have no problem.

## Plugins
Plugins must implement `BadBehavior\Plugins\PluginInterface`.

Unlike the old version, this version doesn't attempt to run anything on its own. All it does is run the checks, the
plugins handle everything else.

### Whitelist
You can set a whitelist by adding an array of 

## Contributing
