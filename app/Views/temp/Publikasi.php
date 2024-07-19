<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Publikasi</h2>

<table>
<thead>
<tr>
                    <?php foreach ($fields as $field): ?>
                        <th><?php echo $field; ?></th>
                    <?php endforeach; ?>
                </tr>
                                    </thead>

                                    <tbody>
                                        <?php $i = 1 ?>

                                        <?php foreach ($data as $row): ?>
                    <tr>
                        <?php foreach ($fields as $field): ?>
                            <td><?php echo $row[$field]; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
                                    </tbody>
</table>

</body>
</html>

