<div class="nk-main">
    <div class="container">
        <div class="nk-gap-2"></div>
        <h3 class="nk-decorated-h-2"><span class="text-main-1"><?php echo $this->lang->line('STR_DARKBLOW_134') ?> <span class="text-white"><?php echo $this->lang->line('STR_DARKBLOW_135') ?></span></span></h3>
        <div class="row vertical-gap justify-content-center">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                <?php echo form_open('', 'id="post_form" autocomplete="off"') ?>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('STR_DARKBLOW_136') ?></label>
                        <select id="item_id" class="form-control">
                            <option value="" disabled selected><?php echo $this->lang->line('STR_DARKBLOW_137') ?></option>
                            <?php foreach($items as $row) : ?>
                                <option value="<?php echo $row['item_id'] ?>"><?php echo $this->trade->ConvertBaseNameItem($row['item_id']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('STR_DARKBLOW_61') ?></label>
                        <input type="number" id="item_price" class="form-control" placeholder="<?php echo $this->lang->line('STR_DARKBLOW_138') ?>">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('STR_DARKBLOW_139') ?></label>
                        <label class="form-control"><?php echo $this->trade->GetDurationLeftEachMonth() ?> Days</label>
                    </div>
                    <div class="form-group text-center">
                        <a href="<?php echo base_url('trade') ?>" class="nk-btn nk-btn-rounded nk-btn-outline nk-btn-color-main-1">Back</a>
                        <input type="submit" id="submit" class="nk-btn nk-btn-rounded nk-btn-outline nk-btn-color-main-5" value="Submit Your Item">
                    </div>
                <?php echo form_close() ?>
                <script>
                    var CSRF_TOKEN = '<?php echo $this->security->get_csrf_hash() ?>';
                    var RETRY = 0;
                    $(document).ready(function(){
                        $('#post_form').on('submit', function(e){
                            e.preventDefault();

                            return Do_SubmitTrade();
                        });
                    });

                    function Do_SubmitTrade()
                    {
                        if ($('#item_id').val() == '' || $('#item_id').val() == null){
                            ShowToast(2000, 'warning', 'Please Select Your Item First.');
                            return;
                        }
                        else if ($('#item_price').val() == '' || $('#item_price').val() == null){
                            ShowToast(2000, 'warning', 'Please Enter Your Item Price.');
                            return;
                        }
                        else{
                            SetAttribute('submit', 'button', 'Processing...');

                            $.ajax({
                                url: '<?php echo base_url('trade/do_post') ?>',
                                type: 'POST',
                                dataType: 'JSON',
                                data: {
                                    '<?php echo $this->security->get_csrf_token_name() ?>' : CSRF_TOKEN,
                                    'item_id' : $('#item_id').val(),
                                    'item_price' : $('#item_price').val()
                                },
                                success: function(data){
                                    var GetString = JSON.stringify(data);
                                    var Result = JSON.parse(GetString);
    
                                    if (Result.response == 'true'){
                                        SetAttribute('submit', 'submit', 'Submit Your Item');
                                        ShowToast(2000, 'success', Result.message);
                                        CSRF_TOKEN = Result.token;
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                    else if (Result.response == 'false'){
                                        SetAttribute('submit', 'submit', 'Submit Your Item');
                                        ShowToast(2000, 'error', Result.message);
                                        CSRF_TOKEN = Result.token;
                                        return;
                                    }
                                    else{
                                        SetAttribute('submit', 'submit', 'Submit Your Item');
                                        ShowToast(2000, 'error', Result.message);
                                        CSRF_TOKEN = Result.token;
                                        return;
                                    }
                                },
                                error: function(){
                                    if (RETRY >= 3){
                                        SetAttribute('submit', 'submit', 'Submit Your Item');
                                        ShowToast(2000, 'error', '<?php echo $this->lang->line('STR_ERROR_14') ?>');
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                    else{
                                        ShowToast(1000, 'info', 'Generate New Request Token...');

                                        $.ajax({
                                            url: '<?php echo base_url('api/getnewtoken') ?>',
                                            type: 'GET',
                                            dataType: 'JSON',
                                            data: {
                                                '<?php echo $this->lib->GetTokenName() ?>' : '<?php echo $this->lib->GetTokenKey() ?>'
                                            },
                                            success: function(data){
                                                var GetString = JSON.stringify(data);
                                                var Result = JSON.parse(GetString);

                                                if (Result.response == 'true'){
                                                    CSRF_TOKEN = Result.token;
                                                }

                                                return Do_SubmitTrade();
                                            },
                                            error: function(){
                                                SetAttribute('submit', 'submit', 'Submit Your Item');
                                                ShowToast(2000, 'error', 'Failed To Sumbit Your Item');
                                                setTimeout(() => {
                                                    window.location.reload();
                                                }, 2000);
                                            }
                                        });
                                    }
                                }
                            });
                        }
                    }
                </script>
            </div>
        </div>
    </div>
</div>