<?php

namespace core\modules\forum\helpers;

use core\modules\forum\models\Post;
use core\modules\forum\models\User;
use core\modules\forum\Podium;
use DateTime;
use DateTimeZone;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Url;

/**
 * Podium Helper
 * Static methods for HTML output and other little things.
 */
class Helper
{
    /**
     * Prepares content for categories administration.
     * @param mixed $category
     * @return string
     */
    public static function adminCategoriesPrepareContent($category)
    {
        $actions = [];
        $actions[] = Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-plus-sign']) . ' ' . Yii::t('podium/view', 'Create new forum'), ['admin/new-forum', 'cid' => $category->id], ['class' => 'btn btn-success btn-xs']);
        $actions[] = Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']), ['admin/edit-category', 'id' => $category->id], ['class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Yii::t('podium/view', 'Edit Category')]);
        $actions[] = Html::tag('span', Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['class' => 'btn btn-danger btn-xs', 'data-url' => Url::to(['admin/delete-category', 'id' => $category->id]), 'data-toggle' => 'modal', 'data-target' => '#podiumModalDelete']), ['data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Yii::t('podium/view', 'Delete Category')]);

        return Html::tag('p', implode(' ', $actions), ['class' => 'pull-right']) . Html::tag('span', Html::encode($category->name), ['class' => 'podium-forum', 'data-id' => $category->id]);
    }

    /**
     * Prepares content for forums administration.
     * @param mixed $forum
     * @return string
     */
    public static function adminForumsPrepareContent($forum)
    {
        $actions = [];
        $actions[] = Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-eye-' . ($forum->visible ? 'open' : 'close')]), ['class' => 'btn btn-xs text-muted', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => $forum->visible ? Yii::t('podium/view', 'Forum visible for guests (if category is visible)') : Yii::t('podium/view', 'Forum hidden for guests')]);
        $actions[] = Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-cog']), ['admin/edit-forum', 'id' => $forum->id, 'cid' => $forum->category_id], ['class' => 'btn btn-default btn-xs', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Yii::t('podium/view', 'Edit Forum')]);
        $actions[] = Html::tag('span', Html::button(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), ['class' => 'btn btn-danger btn-xs', 'data-url' => Url::to(['admin/delete-forum', 'id' => $forum->id, 'cid' => $forum->category_id]), 'data-toggle' => 'modal', 'data-target' => '#podiumModalDelete']), ['data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Yii::t('podium/view', 'Delete Forum')]);

        return Html::tag('p', implode(' ', $actions), ['class' => 'pull-right']) . Html::tag('span', Html::encode($forum->name), ['class' => 'podium-forum', 'data-id' => $forum->id, 'data-category' => $forum->category_id]);
    }

    /**
     * Returns image source for default avatar image in base64.
     * @return string image source
     */
    public static function defaultAvatar()
    {
        return '/resources/images/default_avatar.png';
    }

    /**
     * Returns user tag for deleted user.
     * @param bool $simple whether to return simple tag instead of full
     * @return string tag
     */
    public static function deletedUserTag($simple = false)
    {
        return static::podiumUserTag('', 0, null, null, $simple);
    }

    /**
     * Returns HTMLPurifier configuration set.
     * @param string $type set name
     * @return array configuration
     */
    public static function podiumPurifierConfig($type = '')
    {
        $config = [];

        switch ($type) {
            case 'full':
                $config = [
                    'HTML.Allowed'             => 'p[class],br,b,strong,i,em,u,s,a[href|target],ul,li,ol,span[style|class],h1,h2,h3,h4,h5,h6,sub,sup,blockquote,pre[class],img[src|alt],iframe[class|frameborder|src],hr',
                    'CSS.AllowedProperties'    => 'color,background-color',
                    'HTML.SafeIframe'          => true,
                    'URI.SafeIframeRegexp'     => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
                break;
            case 'markdown':
                $config = [
                    'HTML.Allowed'             => 'p,br,b,strong,i,em,u,s,a[href|target],ul,li,ol,hr,h1,h2,h3,h4,h5,h6,span,pre,code,table,tr,td,th,blockquote,img[src|alt]',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
            case 'default':
            default:
                $config = [
                    'HTML.Allowed'             => 'p[class],br,b,strong,i,em,u,s,a[href|target],ul,li,ol,hr',
                    'Attr.AllowedFrameTargets' => ['_blank']
                ];
        }

        return $config;
    }

    /**
     * Returns user tag.
     * @param string $name user name
     * @param int $role user role
     * @param int|null $id user ID
     * @param bool $simple whether to return simple tag instead of full
     * @param null|mixed $slug
     * @return string tag
     */
    public static function podiumUserTag($name, $role, $id = null, $slug = null, $simple = false)
    {
        $icon = Html::tag('span', '', ['class' => $id ? 'glyphicon glyphicon-user' : 'glyphicon glyphicon-ban-circle']);
        $url = $id ? ['members/view', 'id' => $id, 'slug' => $slug] : '#';
        switch ($role) {
            case 0:
                $colourClass = 'text-muted';
                break;
            case User::ROLE_MODERATOR:
                $colourClass = 'text-info';
                break;
            case User::ROLE_ADMINISTRATOR:
                $colourClass = 'text-danger';
                break;
            case User::ROLE_USER:
            default:
                $colourClass = 'text-warning';
        }
        $encodedName = Html::tag('span', $icon . ' ' . ($id ? Html::encode($name) : Yii::t('podium/view', 'user deleted')), ['class' => $colourClass]);

        if ($simple) {
            return $encodedName;
        }

        return Html::a($encodedName, $url, ['class' => 'btn btn-xs btn-default', 'data-pjax' => '0']);
    }

    /**
     * Returns quote HTML.
     * @param Post $post post model to be quoted
     * @param string $quote partial text to be quoted
     * @return string
     */
    public static function prepareQuote($post, $quote = '')
    {
        if (Podium::getInstance()->podiumConfig->get('forum.use_wysiwyg') === '0') {
            $content = !empty($quote) ? '[...] ' . HtmlPurifier::process($quote) . ' [...]' : $post->content;

            return '> ' . $post->author->podiumTag . ' @ ' . Podium::getInstance()->formatter->asDatetime($post->created_at) . "\n> " . $content . "\n";
        }
        $content = !empty($quote) ? '[...] ' . nl2br(HtmlPurifier::process($quote)) . ' [...]' : $post->content;

        return Html::tag('blockquote', $post->author->podiumTag . ' @ ' . Podium::getInstance()->formatter->asDatetime($post->created_at) . '<br>' . $content) . '<br>';
    }

    /**
     * Returns background image style base64 encoded.
     * @return string style
     */
    public static function replyBgd()
    {
        return 'style="background-repeat:repeat-y;background-position:top right;background-image:url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAAAUCAYAAAB7wJiVAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyBpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBXaW5kb3dzIiB4bXBNTTpJbnN0YW5jZUlEPSJ4bXAuaWlkOkI2NTVERkRDREEyRTExRTRCRkI5OEQyMTc5QURDMkNDIiB4bXBNTTpEb2N1bWVudElEPSJ4bXAuZGlkOkI2NTVERkREREEyRTExRTRCRkI5OEQyMTc5QURDMkNDIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6QjY1NURGREFEQTJFMTFFNEJGQjk4RDIxNzlBREMyQ0MiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6QjY1NURGREJEQTJFMTFFNEJGQjk4RDIxNzlBREMyQ0MiLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6k5fCuAAAAyklEQVR42uyXsQ2DMBBFIcooLnCVBajcpaXOJqnZhDojULEDltxkE3KWLpKVAtxwSvGe9EXBr/4TSNemlBqllwySIPGSVTJLXpIlF5xzDZzLVZ8PyVPSFe9umrtklEzMdT4X/TJ+ZZR0+r5nLhshw46MUsrAXDZCQmU3MJeNEF/Z9cxlI2St7K7MZSNkruzOzGUjJN8Z8aAXtQcGQha9M+KOjPF7HILNYZiPvvfRpQ7n027bxgp/9ssChABCEAIIQQggBCFgyUeAAQBSzyA8dwka9AAAAABJRU5ErkJggg==\');"';
    }

    /**
     * Returns role label HTML.
     * @param int|null $role role ID
     * @return string
     */
    public static function roleLabel($role = null)
    {
        switch ($role) {
            case User::ROLE_ADMINISTRATOR:
                $label = 'danger';
                $name = ArrayHelper::getValue(User::getRoles(), $role);
                break;
            case User::ROLE_MODERATOR:
                $label = 'info';
                $name = ArrayHelper::getValue(User::getRoles(), $role);
                break;
            default:
                $label = 'warning';
                $name = ArrayHelper::getValue(User::getRoles(), User::ROLE_USER);
        }

        return Html::tag('span', $name, ['class' => 'label label-' . $label]);
    }

    /**
     * Returns sorting icon.
     * @param string|null $attribute sorting attribute name
     * @return string|null icon HTML or null if empty attribute
     */
    public static function sortOrder($attribute = null)
    {
        if (!empty($attribute)) {
            $sort = Yii::$app->request->get('sort');
            if ($sort === $attribute) {
                return ' ' . Html::tag('span', '', ['class' => 'glyphicon glyphicon-sort-by-alphabet']);
            }
            if ($sort === '-' . $attribute) {
                return ' ' . Html::tag('span', '', ['class' => 'glyphicon glyphicon-sort-by-alphabet-alt']);
            }
        }

        return null;
    }

    /**
     * Returns User status label.
     * @param int|null $status status ID
     * @return string label HTML
     */
    public static function statusLabel($status = null)
    {
        switch ($status) {
            case User::STATUS_ACTIVE:
                $label = 'info';
                $name = ArrayHelper::getValue(User::getStatuses(), $status);
                break;
            case User::STATUS_BANNED:
                $label = 'warning';
                $name = ArrayHelper::getValue(User::getStatuses(), $status);
                break;
            default:
                $label = 'default';
                $name = ArrayHelper::getValue(User::getStatuses(), User::STATUS_REGISTERED);
        }

        return Html::tag('span', $name, ['class' => 'label label-' . $label]);
    }

    /**
     * Returns time zones with current offset array.
     * @return array
     */
    public static function timeZones()
    {
        $timeZones = [];

        $timezone_identifiers = DateTimeZone::listIdentifiers();
        sort($timezone_identifiers);

        $timeZones['UTC'] = Yii::t('podium/view', 'default (UTC)');

        foreach ($timezone_identifiers as $zone) {
            if ($zone !== 'UTC') {
                $zoneName = $zone;
                $timeForZone = new DateTime(null, new DateTimeZone($zone));
                $offset = $timeForZone->getOffset();
                if (is_numeric($offset)) {
                    $zoneName .= ' (UTC';
                    if ($offset !== 0) {
                        $offset = $offset / 60 / 60;
                        $offsetDisplay = floor($offset) . ':' . str_pad(60 * ($offset - floor($offset)), 2, '0', STR_PAD_LEFT);
                        $zoneName .= ' ' . ($offset < 0 ? '' : '+') . $offsetDisplay;
                    }
                    $zoneName .= ')';
                }
                $timeZones[$zone] = $zoneName;
            }
        }

        return $timeZones;
    }

    /**
     * Adds forum name to view title.
     * @param string $title
     * @return string
     */
    public static function title($title)
    {
        return $title . ' - ' . Podium::getInstance()->podiumConfig->get('forum.name');
    }

    /**
     * Comparing versions.
     * @param array $a
     * @param array $b
     * @return string
     * @since 0.2
     */
    public static function compareVersions($a, $b)
    {
        $versionPos = max(count($a), count($b));
        while (count($a) < $versionPos) {
            $a[] = 0;
        }
        while (count($b) < $versionPos) {
            $b[] = 0;
        }

        for ($v = 0; $v < count($a); $v++) {
            if ((int)$a[$v] < (int)$b[$v]) {
                return '<';
            }
            if ((int)$a[$v] > (int)$b[$v]) {
                return '>';
            }
        }

        return '=';
    }
}
