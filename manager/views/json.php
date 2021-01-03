<?php
require_once __DIR__ . "/../config.php";
?>
<?php if ($renderDetailView): ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/ir-black.min.css">
<div class="card">
    <div class="card-body">
        <h4 class="card-title">JSON</h4>
        <p class="card-text">Text</p>
        <div class="profileJson">
            <pre><code class="json"><?=$activeFile->json()?></code></pre>
        </div>
    </div>
</div>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
<script>
hljs.initHighlightingOnLoad();
</script>
<?php endif;?>