<div class='comment-form'>
    <form method=post>
        <input type='hidden' name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
        <input type='hidden' name='key' value="<?=$key?>">
        <fieldset>
            <!--<legend>Leave a comment</legend>-->
            <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
            <p><label>Name:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
            <p><label>Homepage:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
            <p><label>Email:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
            <input type='hidden' name='id' value='<?=$id?>'/>
            <p class=buttons>
                <input type='submit' name='doCreate' value='Comment' onClick="this.form.action = '<?=$this->url->create('comment/add')?>'"/>
                <input type='submit' name='doRemoveAll' value='Remove all' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
            </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
