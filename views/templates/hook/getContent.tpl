{if isset($confirmation)}
    <div class="alert-success alert">
        {l s="Configuration has been updated" mod='mymodcomments'}
    </div>
{/if}

<form method="post" action="" class="defaultForm form-horizontal">
    <div class="panel">
        <div class="panel-heading">
            <i class="icon-cogs"></i>
            {l s='Module configuration' mod='mymodcomments'}
        </div>

        <div class="form-wrapper">
            <div class="form-group">
                <label for="" class="control-label col-lg-3">{l s='Activate grades' mod='mymodcomments'}</label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="">
                    <input type="radio" id="enable_grades_1" name="enable_grades" value="1" {if $enable_grades}checked{/if}>
                    <label for="enable_grades_1" class="t">{l s='Yes' mod='mymodcomments'}</label>

                    <img src="../img/admin/disabled.gif" alt="">
                    <input type="radio" id="enable_grades_0" name="enable_grades" value="0" {if !$enable_grades}checked{/if}>
                    <label for="enable_grades_0" class="t">{l s='No' mod='mymodcomments'}</label>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-lg-3">{l s="Activate comments" mod='mymodcomments'} </label>
                <div class="col-lg-9">
                    <img src="../img/admin/enabled.gif" alt="">
                    <input type="radio" id="enable_comments_1" name="enable_comments" value="1" {if $enable_comments}checked{/if}>
                    <label for="enable_comments_1" class="t">{l s='Yes' mod='mymodcomments'}</label>

                    <img src="../img/admin/disabled.gif" alt="">
                    <input type="radio" id="enable_comments_0" name="enable_comments" value="0" {if !$enable_comments}checked{/if}>
                    <label for="enable_comments_0" class="t">{l s='No' mod='mymodcomments'}</label>
                </div>
            </div>

            <div class="panel-footer">
                <button class="btn btn-default pull-right" name="submit_mymodcomments_form" value="1" type="submit">
                    <i class="process-icon-save"></i> {l s='Save' mod='mymodcomments'}
                </button>
            </div>
        </div>
    </div>
</form>