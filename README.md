# Kirby Discord plugin

Send messages from your Kirby site to a Discord channel – for example when a page gets published, a form is submitted or an order comes in. The plugin wraps Discord's webhook API in a single PHP method.

## Requirements

- Kirby 4, 5 or 6
- PHP 8.3, 8.4 or 8.5

## Installation

### Composer

```
composer require getkirby/discord
```

### Download

Download and copy this repository to `/site/plugins/discord`.

### Git submodule

```
git submodule add https://github.com/getkirby/discord.git site/plugins/discord
```

## Setup

### 1. Create a webhook in Discord

1. Click on the "Edit Channel" icon right next to the channel name in the sidebar
2. Go to "Integrations"
3. Go to "Webhooks"
4. Create a new webhook
5. Copy the webhook URL

### 2. Store the webhook URL

> [!IMPORTANT]
> Anyone who knows the webhook URL can post to your channel. Keep it out of your Git repository.

Put the URL into a [domain-specific config file](https://getkirby.com/docs/guide/configuration#multi-environment-setup) and add that file to your `.gitignore`. Then install it manually on your server:

```php
// site/config/config.example.com.php
return [
  'discord' => [
    'webhook' => 'https://discord.com/api/webhooks/xxx/xxx'
  ]
];
```

Alternatively, read it from an environment variable.

## Usage

```php
use Kirby\Discord\Discord;

Discord::submit(
  webhook: option('discord.webhook'),
  title: '👋 Hello from Kirby',
  description: 'This is my first message'
);
```

All parameters besides `webhook` are optional. Here is a message that uses most of them:

```php
use Kirby\Discord\Discord;

Discord::submit(
  webhook: option('discord.webhook'),
  username: 'kirbybot',
  avatar: 'https://example.com/avatar.jpg',
  title: '🔥 Message Title',
  color: '#ebc747',
  description: 'Here goes some nice text',
  author: [
    'name' => 'Ron Swanson',
    'url'  => 'https://example.com',
    'icon' => 'https://example.com/someicon.png'
  ],
  fields: [
    [
      'name'  => 'This is a custom field',
      'value' => 'Add any value here'
    ],
    [
      'name'  => 'This is another one',
      'value' => 'https://canbeanurl.com'
    ],
  ],
  footer: 'Some text for the footer'
);
```

### Parameters

| Parameter     | Type                 | Description                                                                         |
| ------------- | -------------------- | ----------------------------------------------------------------------------------- |
| `webhook`     | `string`             | The webhook URL (required)                                                          |
| `content`     | `string`             | Plain message text above the embed                                                  |
| `username`    | `string`             | Overrides the default name of the webhook                                           |
| `avatar`      | `string`             | Image URL that overrides the default avatar of the webhook                          |
| `title`       | `string`             | Title of the embed                                                                  |
| `description` | `string`             | Main text of the embed, supports Discord's Markdown                                 |
| `color`       | `string\|int`        | Color of the embed's left border, as hex string (`'#ebc747'`) or integer            |
| `author`      | `array\|Author`      | Author with `name` and the optional `url` and `icon` (image URL)                    |
| `fields`      | `array`              | List of fields, each with `name`, `value` and an optional `inline` flag             |
| `image`       | `string`             | URL of a large image below the text                                                 |
| `thumbnail`   | `string`             | URL of a small image in the top right corner                                        |
| `footer`      | `string`             | Text at the bottom of the embed                                                     |
| `timestamp`   | `string\|DateTime`   | Time next to the footer, as ISO 8601 string or `DateTime` object                    |
| `dryrun`      | `bool`               | Returns the request data as array instead of sending it                             |

To get an idea of what each parameter does, check out this [embed visualizer](https://leovoel.github.io/embed-visualizer/).

### Author icon from Gravatar

`Author::gravatar()` returns the Gravatar URL for an email address. The optional second argument sets Gravatar's fallback image for addresses without an avatar, e.g. `mp` or `identicon`:

```php
use Kirby\Discord\Author;
use Kirby\Discord\Discord;

Discord::submit(
  webhook: option('discord.webhook'),
  title: 'New comment',
  author: [
    'name' => $user->name()->value(),
    'icon' => Author::gravatar($user->email(), 'mp')
  ]
);
```

### Example: notify on publish

Send a message whenever a page gets published, using a [hook](https://getkirby.com/docs/reference/plugins/hooks/page-changestatus-after):

```php
// site/config/config.php
use Kirby\Discord\Discord;

return [
  'hooks' => [
    'page.changeStatus:after' => function ($newPage, $oldPage) {
      if ($newPage->isListed() === true && $oldPage->isListed() === false) {
        Discord::submit(
          webhook: option('discord.webhook'),
          title: '📢 ' . $newPage->title()->value() . ' is online',
          description: $newPage->url()
        );
      }
    }
  ]
];
```

### Checking the response

`Discord::submit()` returns a [`Kirby\Http\Remote`](https://getkirby.com/docs/reference/objects/http/remote) object. Discord answers a successful request with the status code `204`:

```php
$response = Discord::submit(/* … */);

if ($response->code() !== 204) {
  // something went wrong, e.g. log $response->content()
}
```

### Testing

Pass `dryrun: true` to get the data that would be sent to Discord as an array, without sending anything.

## Development

The dev tools run through [cpx](https://github.com/RedExplosion/cpx), so you need it installed globally:

```
composer global require cpx/cpx
composer install
```

- `composer test` runs the unit tests
- `composer fix` fixes the code style
- `composer analyze` validates `composer.json` and runs Psalm
- `composer ci` runs all of the above

## What's Kirby?

- **[getkirby.com](https://getkirby.com)** – Get to know the CMS.
- **[Try it](https://getkirby.com/try)** – Take a test ride with our online demo. Or download one of our kits to get started.
- **[Documentation](https://getkirby.com/docs/guide)** – Read the official guide, reference and cookbook recipes.
- **[Issues](https://github.com/getkirby/kirby/issues)** – Report bugs and other problems.
- **[Feedback](https://feedback.getkirby.com)** – You have an idea for Kirby? Share it.
- **[Forum](https://forum.getkirby.com)** – Whenever you get stuck, don't hesitate to reach out for questions and support.
- **[Discord](https://chat.getkirby.com)** – Hang out and meet the community.
- **[YouTube](https://youtube.com/kirbyCasts)** - Watch the latest video tutorials visually with Bastian.
- **[Mastodon](https://mastodon.social/@getkirby)** – Spread the word.
- **[Bluesky](https://bsky.app/profile/getkirby.com)** – Tell a friend.

---

## License

MIT

## Credits

- [Kirby Team](https://getkirby.com)
