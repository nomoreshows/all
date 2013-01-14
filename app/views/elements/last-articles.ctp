<!-- News -->
       			<?php
				if (!empty($news)) { 
				foreach ($news as $i => $article) {
					if($i == 1) break;
				?>
                    <div class="onenews2">
                        <h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2> <br />
                        <?php 
                        if (empty($article['Article']['show_id'])) {
                        echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        } else {
                            echo $html->link($html->image('show/' . $article['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        }
                        ?>
                        <div class="textnews">
                            <p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
                            <p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
                        </div>
                    </div>
				<?php
				}
				}
				if (!empty($news)) { echo '<br />';
				foreach ($news as $i => $article) {
					if($i > 0) {
				?>
					<div class="onenews2">
						<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($article['Comment']); ?></p>
					</div>
				<?php
					}
				} ?>
				<p class="suite">Actualité <?php echo $html->link('&raquo; Toutes les news', '/actualite', array('escape' => false)); ?></p>
                <?php
				}
				?>
                
                <hr /><br />
                <!-- Critiques -->
                <?php
				if (!empty($critiques)) { 
				foreach ($critiques as $i => $article) {
					if($i == 1) break;
				?>
                    <div class="onenews2">
                        <h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2> <br />
                        <?php 
                        if (empty($article['Article']['show_id'])) {
                        echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        } else {
                            echo $html->link($html->image('show/' . $article['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        }
                        ?>
                        <div class="textnews">
                            <p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
                            <p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
                        </div>
                    </div>
				<?php
				}
				}
				if (!empty($critiques)) {  echo '<br />';
				foreach ($critiques as $i => $article) {
					if($i > 0) {
				?>
					<div class="onenews2">
						<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($article['Comment']); ?></p>
					</div>
				<?php
					}
				} ?>
                <p class="suite">Critiques <?php echo $html->link('&raquo; Toutes les critiques', '/critiques', array('escape' => false)); ?></p>
                <?php
				}
				?>
                
                <hr /><br />
                <!-- Bilans -->
                <?php
				if (!empty($bilans)) { 
				foreach ($bilans as $i => $article) {
					if($i == 1) break;
				?>
                    <div class="onenews2">
                        <h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2> <br />
                        <?php 
                        if (empty($article['Article']['show_id'])) {
                        echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        } else {
                            echo $html->link($html->image('show/' . $article['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        }
                        ?>
                        <div class="textnews">
                            <p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
                            <p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
                        </div>
                    </div>
				<?php
				}
				}
				if (!empty($bilans)) {  echo '<br />';
				foreach ($bilans as $i => $article) {
					if($i > 0) {
				?>
					<div class="onenews2">
						<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($article['Comment']); ?></p>
					</div>
				<?php
					}
				} ?>
                <p class="suite">Bilans <?php echo $html->link('&raquo; Tous les bilans', '/dossiers', array('escape' => false)); ?></p>
                <?php
				}
				?>
                
                <hr /><br />
                <!-- Vidéos -->
                <?php
				if (!empty($videos)) { 
				foreach ($videos as $i => $article) {
					if($i == 1) break;
				?>
                    <div class="onenews2">
                        <h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2> <br />
                        <?php 
                        if (empty($article['Article']['show_id'])) {
                        echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        } else {
                            echo $html->link($html->image('show/' . $article['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        }
                        ?>
                        <div class="textnews">
                            <p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
                            <p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
                        </div>
                    </div>
				<?php
				}
				}
				if (!empty($videos)) {  echo '<br />';
				foreach ($videos as $i => $article) {
					if($i > 0) {
				?>
					<div class="onenews2">
						<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($article['Comment']); ?></p>
					</div>
				<?php
					}

				} ?>
                <p class="suite">Vidéos <?php echo $html->link('&raquo; Toutes les vidéos', '/videos', array('escape' => false)); ?></p>
                <?php
				}
				?>
                
                <hr /><br />
                <!-- Focus -->
                <?php
				if (!empty($focus)) { 
				foreach ($focus as $i => $article) {
					if($i == 1) break;
				?>
                    <div class="onenews2">
                        <h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2> <br />
                        <?php 
                        if (empty($article['Article']['show_id'])) {
                        echo $html->link($html->image('article/thumb.news.' . $article['Article']['photo'], array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        } else {
                            echo $html->link($html->image('show/' . $article['Show']['menu'] . '_t.jpg', array('class' => 'imgleft imgnews', 'width' => 78)), '/article/' . $article['Article']['url'] . '.html', array('escape' => false)); 
                        }
                        ?>
                        <div class="textnews">
                            <p class="date"><?php $timestamp = strtotime($article['Article']['created']); e(strftime("%d/%m/%Y", $timestamp)); ?></p> <p class="comments"><?php echo count($article['Comment']); ?> commentaire<?php if(count($article['Comment']) > 1) echo 's'; ?></p>
                            <p class="text"><?php echo $text->truncate($article['Article']['chapo'], 200, ' ...', false); ?></p>
                        </div>
                    </div>
				<?php
				}
				}
				if (!empty($focus)) {  echo '<br />';
				foreach ($focus as $i => $article) {
					if($i > 0) {
				?>
					<div class="onenews2">
						<h2><?php echo $html->link($article['Article']['name'], '/article/' . $article['Article']['url']. '.html'); ?></h2><p class="comments"><?php echo count($article['Comment']); ?></p>
					</div>
				<?php
					}
				} ?>
                <p class="suite">Focus <?php echo $html->link('&raquo; Tous les focus', '/dossiers', array('escape' => false)); ?></p>
                <?php
				}
				?>
                <br />