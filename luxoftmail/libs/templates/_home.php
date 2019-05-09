<?php get_header();?>
<section id="primary" class="content-area" style="text-align: center;">
    <main id="main" class="site-main">
        <form method="post" id="address_form">
            <div class="form-group">
                <label>
                    <?php echo __('Address');?>
                </label>
                <input type="text" name="address" id="luxoft_address" />
            </div>
            <br />
            <div class="form-group">
                <input type="submit" name="save" value="save" />
            </div>
        </form>
    </main>
</section>
<?php get_footer();?>