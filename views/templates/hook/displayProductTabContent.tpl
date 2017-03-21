{if $enable_comments OR $enable_grades}
    <h3 id="mymodcomments-content-tab" class="page-product-heading"
            {if isset($new_comment_posted)} data-scroll="true"{/if}>
        {l s='Product comments' mod='mymodcomments'}
    </h3>
{/if}

<div class="rte">

    {foreach from=$comments item=comment}
        <div class="mymodcomments-comment">
            <p>
                <img src="http://www.gravatar.com/avatar/{$comment.email|trim|strtolower|md5}?s=45" class="pull-left img-thumbnail mymodcomments-avatar" alt="">
                <strong>{l s='Comment' mod='mymodcomments'} #{$comment.id_mymod_comment}:</strong>
                {$comment.comment} <br>
                <strong>{l s='Grade' mod='mymodcomments'}:</strong> {$comment.grade}/5
                <br>
                {$comment.firstname} {$comment.lastname|substr:0:1|strtoupper}.
            </p>

        </div>

    {/foreach}


    <form action="" method="POST" id="comment-form">
        <div class="form-group">
            <label for="firstname">
                {l s='Firstname:' mod='mymodcomments'}
            </label>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" name="firstname" id="firstname" class="form-control">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="email">
                {l s='Email:' mod='mymodcomments'}
            </label>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" name="email" id="email" class="form-control">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname">
                {l s='Lastname:' mod='mymodcomments'}
            </label>
            <div class="row">
                <div class="col-xs-4">
                    <input type="text" name="lastname" id="lastname" class="form-control">
                </div>
            </div>
        </div>
        {if $enable_grades }
            <div class="form-group">
                <label for="grade">{l s='Grade' mod='mymodcomments'}:</label>
                <div class="row">
                    <div class="col-xs-4">
                        <select name="grade" id="grade" class="form-control">
                            <option value="0">-- {l s='Choose' mod='mymodcomments'} --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
        {/if}
        {if $enable_comments }
            <div class="form-group">
                <label for="comment">{l s='Comment' mod='mymodcomments'} :</label>
                <textarea name="comment" id="comment" cols="30" rows="10" class="form-control"></textarea>
            </div>
        {/if}

        {if $enable_comments OR $enable_grades}
            <div class="submit">
                <button type="submit" name="mymod_pc_submit_comment" class="button btw btn-default button-medium">
                    <span>{l s='Send' mod='mymodcomments'} <i class="icon-chevron-right right"></i></span>
                </button>
            </div>
        {/if}
    </form>
</div>