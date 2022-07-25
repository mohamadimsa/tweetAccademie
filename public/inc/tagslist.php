<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 left-tags mt-3 mb-3 bg-color rounded">
			<ul class="bg-color list-group">
				<?php foreach ($hashtags as $tag): ?>
					<li class="list-group-item bg-color text-secondary">
						<a href="/Twitter/tags/<?=$tag['name']?>">#<?=$tag['name']?></a> - <small><i><?=$tag['count']?> tweets</i></small>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	</div>
</div>