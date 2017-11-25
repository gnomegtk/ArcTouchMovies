<link rel="stylesheet" type="text/css" href="media/css/main.css">
<table border="1">
    <caption>
        <b>Upcoming movies</b>
    </caption>
    <thead>
        <tr>
            <?php foreach ($movies_fields as $field): ?>
                <th><?php echo $field; ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($movies as $movie): ?>
            <tr class="tr-movie" onclick="window.location ='?method=movie&id=<?php echo $movie->id; ?>'; ">
                <?php foreach ($movies_fields as $field): ?>
                    <?php if ($field == 'genre_ids'): ?>
                        <td>
                            <ul>
                                <?php foreach ($movie->$field as $item): ?>
                                    <li><?php echo $genres[$item]; ?>
                                <?php endforeach; ?>
                            </ul>
                        </td>
                    <?php elseif (substr($field, -4) != 'path'): ?>
                        <td><u><?php echo $movie->$field; ?></u></td>
                    <?php else: ?>
                        <td><img src="http://image.tmdb.org/t/p/w185/<?php echo $movie->$field; ?>" /></td>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br />

<?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <?php if ($i != $page): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>&nbsp;
    <?php else: ?>
        <?php echo $i; ?>&nbsp;
    <?php endif; ?>
<?php endfor; ?>
