<?php

require_once __DIR__ . "/../config.php";
use Angorb\BetaflightProfiler\Reader;

/* icon style setup */
$icons = [
    'vtx' => '<i class="fas fa-broadcast-tower"></i>',
];

$files = glob($filesDir . "/*.txt");

$profiles = [];
$filters = [
    'boards' => array(),
];
foreach ($files as $file) {

    $profile = Reader::fromFile($file);

    /* filters */
    if ($profile->getBoardName() != "" &&
        !in_array($profile->getBoardName(), $filters['boards'])) {
        $filters['boards'][] = $profile->getBoardName();
    }

    /* assemble table data */
    $profiles[] = [
        'filepath' => $file,
        'filename' => basename($file, ".txt"),
        'modified' => filemtime($file),
        'data' => Reader::fromFile($file),
    ];
}
?>
<!-- files.php -->
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Betaflight Profiles</h4>
        <p class="card-text">Text</p>
        <table class="table table-striped table-bordered dt-responsive nowrap" id="profileTable">
            <thead>
                <tr>
                    <th>Filename</th>
                    <th>Board Name</th>
                    <th>Craft Name</th>
                    <th>Modified</th>
                    <th>Features</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($profiles as $profile): ?>
                <tr>
                    <td>
                        <a href="<?=$profile['filepath']?>" download><?=$profile['filename']?></a>
                    </td>
                    <td scope="row"><?=$profile['data']->getBoardName() ?? "Unknown"?></td>
                    <td><?=$profile['data']->getCraftName() ?? ""?></td>
                    <td><?=date("m/d/Y g:i:sa", $profile['modified'])?></td>
                    <td>
                        <?=empty($profile['data']->hasVTX()) ? '' : $icons['vtx']?>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
        <div id="fileUploader">
            <h4>Upload File:</h4>
            <form enctype="multipart/form-data" action="actions/upload.php" method="post" id="fileUploadForm">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" name="file" accept=".txt">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
                <button id="uploadFormSubmit" name="submit" type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>