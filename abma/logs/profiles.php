<title>سجلات الزيارات</title>
<h4 class="py-3 mb-4"><span class="text-muted fw-light">السِجلات /</span> سجل زيارات المستخدمين</h4>

<div class="row">
</div>
<div class="card mt-2">
    <div class="table-responsive text-nowrap">
        <table class="orders_table table text-right">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>العضو</th>
                    <th>زار</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                dbSelect("visits", "id, user_id, user_profile, date", "ORDER BY id DESC");
                foreach ($rows as $row) {
                    dbSelect("users", "name, lastname", "WHERE id = ?", [$row['user_id']]);
                    $user = $rows[0]['name'] . " " . $rows[0]['lastname'];
                    dbSelect("users", "name, lastname", "WHERE id = ?", [$row['user_profile']]);
                    $visit = $rows[0]['name'] . " " . $rows[0]['lastname'];

                    echo '
                    <tr>
                    <td>' . $row['id'] . '</td>
                    <td><a href="users/' . $row['user_id'] . '/edit" target="_blank">' . $user . '</a></td>
                    <td><a href="users/' . $row['user_profile'] . '/edit" target="_blank">' . $visit . '</a></td>
                    <td>' . $row['date'] . '<br><span class="badge bg-label-dark rounded-pill me-3">' . ago($row['date'], true) . '</span></td>
                    </tr>
                    ';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script src="js/tables.js"></script>