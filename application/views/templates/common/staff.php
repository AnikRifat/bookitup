
<?php if ($template == 2): ?>
    <?php include APPPATH.'views/include/banner2.php'; ?>
<?php endif ?>

<section class="bg-light p-6">
    <div class="container">
        <div class="rows d-flex justify-content-center hide-xs">
            <h2 class="pt-2"><?php echo html_escape($page_title) ?></h2>
        </div>
    </div>
</section>

<section class="pt-8 border-top-light">
    <div class="container p-0">
        <form class="sort_form hide" method="get" action="<?php echo base_url('company/services/'.$slug) ?>">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <select name="staffs" class=" sort_staff nice_select wide">
                            <option value=""><?php echo trans('sort-by-staffs') ?></option>
                            <option value="0"><?php echo trans('all') ?></option>
                            <?php foreach ($staffs as $staff): ?>
                                <option <?php if(isset($_GET['staffs']) && $_GET['staffs'] == $staff->id){echo "selected";} ?> value="<?php echo html_escape($staff->id); ?>"><?php echo html_escape($staff->name); ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 ml-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" aria-describedby="button-addon2" autocomplete="off" placeholder="<?php echo trans('search') ?>">
                        <div class="input-group-append">
                            <button class="btn btn-secondary sort_btn" type="button" id="button-addon2"><i class="fas fa-search"></i> </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- services -->
        <div class="row">
            <?php $i=1; foreach ($staffs as $staff): ?>
                <?php include APPPATH.'views/include/staff_items_'.$template.'.php'; ?>
            <?php $i++; endforeach; ?>
        </div>
        <!-- End services -->
    </div>
</section>