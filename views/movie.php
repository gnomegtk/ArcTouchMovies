<link rel="stylesheet" type="text/css" href="media/css/main.css">
<table border="1">
    <caption>
        <b><?php echo $movie_data['original_title']; ?></b>
    </caption>
    <tbody>
        <?php foreach ($movie_data as $field => $data): ?>
            <tr>
                <th><?php echo $field; ?></th>
                <?php if (!is_array($data)): ?>
                    <?php if (substr($field, -4) != 'path'): ?>
                        <td><?php echo $data; ?></td>
                    <?php else: ?>
                        <td><img src="http://image.tmdb.org/t/p/w185/<?php echo $data; ?>" /></td>
                    <?php endif; ?>
                <?php else: ?>
                    <td>
                        <ul>
                            <?php foreach ($data as $item): ?>
                                <li><?php echo $item->name; ?>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>