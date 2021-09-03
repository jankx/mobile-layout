<?php foreach ($buttons as $name => $button_args) : ?>
    <?php $props = wp_parse_args($button_args, array(
        'link' => '',
        'icon' => '',
        'image' => '',
        'text' => '',
        'callback' => '',
    )) ?>
    <div class="bottom-nav-item <?php echo 'nav-' . $name; ?><?php echo empty($props['link']) ? ' no-link' : ' has-link'; ?>">
    <?php if (is_callable($props['callback'])) : ?>
        <?php call_user_func($props['callback'], $props, $name); ?>
    <?php else : ?>
        <?php if ($props['link']) : ?>
            <a class="nav-link" href="<?php echo $props['link']; ?>">
        <?php endif; ?>
            <?php if ($props['icon']) : ?>
                <span class="nav-icon <?php echo $props['icon']; ?>"></span>
            <?php endif; ?>
            <?php if ($props['image']) : ?>
                <span class="nav-image">
                    <img src="<?php echo $props['image']; ?>" alt="<?php echo $props['text']; ?>">
                </span>
            <?php endif; ?>
            <?php if ($props['text']) : ?>
                <span class="nav-text">
                    <?php echo $props['text']; ?>
                </span>
            <?php endif; ?>
        <?php if ($props['link']) : ?>
            </a>
        <?php endif; ?>
    <?php endif; ?>
    </div>
<?php endforeach; ?>
