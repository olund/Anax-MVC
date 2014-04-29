<hr>

<h2>Comments</h2>

<?php if (is_array($comments) && !empty($comments)) : ?>
	<div class='comments'>
		<?php foreach ($comments as $id => $comment) : ?>
			
			<div class=comment-header>
				<p><?=$comment['name']?> @ <?=$comment['ip']?></p>
			</div>
			
			<div class=comment-content>
				<p><?=$comment['content']?></p>
			</div>

			<div class="comment-footer">
				<?=$comment['mail']?> | <?=$comment['web']?>
			</div>


			<form method=post class='comment'>
				<input type=hidden name="key" value="<?=$key?>">
			    <input type=hidden name="redirect" value="<?=$this->url->create($this->request->getCurrentUrl())?>">
				<input type=hidden name="id" value="<?=$id?>">
                <input class="btn" type='submit' name='doRemove' value='Delete' onclick="this.form.action = '<?= $this->url->create('comment/remove') ?>'">
                <input class="btn" type='submit' name='doEdit' value='Edit' onclick="this.form.action = '<?= $this->url->create('comment/edit') ?>'">
			</form>

		<?php endforeach; ?>
	</div>
<?php endif; ?>

