<div class="container-fluid dashboard-4">
    <div class="row">
        <div class="col-xl-12 col-md-12 proorder-md-1">
            <div class="row">
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body student">
                            <div class="d-flex gap-2 align-items-end">
                                <div class="flex-grow-1">
                                    <h2><?= number_format($total_employee, 0) ?></h2>
                                    <p class="mb-0 text-truncate"> Employees</p>
                                    <span class="f-w-500 font-success">Present - <?= $present ?></span><br>
                                    <span class="f-w-500 font-danger">Absent - <?= $absent ?></span>
                                </div>
                                <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/employee.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body student-2">
                            <div class="d-flex gap-2 align-items-end">
                                <div class="flex-grow-1">
                                    <h2><?= number_format($inventoryTotal, 0) ?></h2>
                                    <p class="mb-0 text-truncate"> Inventory</p>
                                    <span class="f-w-500 font-success">Available - <?= $availableCount ?></span><br>
                                    <span class="f-w-500 font-danger">Unavailable - <?= $unavailableCount ?></span>
                                </div>
                                <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/inventory.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body student-3">
                            <div class="d-flex gap-2 align-items-end">
                                <div class="flex-grow-1">
                                    <h2>₱<?= number_format($totalExpenses, 2) ?></h2>
                                    <p class="mb-0 text-truncate"> Monthly Expenses</p>
                                    <div class="d-flex">
                                        as of <?= date('F') ?>
                                    </div>
                                    <br>
                                </div>
                                <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/transaction.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card">
                        <div class="card-body student-4">
                            <div class="d-flex gap-2 align-items-end">
                                <div class="flex-grow-1">
                                    <h2><?= number_format($projectTotal, 0) ?></h2>
                                    <p class="mb-0 text-truncate"> Projects</p>
                                    <span class="f-w-500 font-success">Completed - <?= $projectCompleted ?></span><br>
                                    <span class="f-w-500 font-warning">In Progress - <?= $projectInprogress ?></span>
                                </div>
                                <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/project.png" alt=""></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12 col-md-12 proorder-md-4">
            <div class="card">
                <div class="card-header card-no-border pb-0">
                    <div class="header-top">
                        <h4>Recent Attendance</h4>
                    </div>
                </div>
                <div class="card-body assignments-table">
                    <div class="table-responsive theme-scrollbar">
                        <table class="table display" id="attendance-table" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id no </th>
                                    <th>Employee</th>
                                    <th>Date </th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attendance as $row): ?>
                                    <tr>
                                        <td> <span><?= sprintf('%04d', $row['employee_id']) ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0"><img class="img-40" src="uploads/<?= $row['photo'] ?>" alt=""></div>
                                                <div class="flex-grow-1 ms-2">
                                                    <h6><?= $row['full_name'] ?></h6>
                                                </div>
                                                <div class="active-status active-online"></div>
                                            </div>
                                        </td>
                                        <td> <?= ($d = DateTime::createFromFormat('Y-m-d', $row['date'])) ? $d->format('F j, Y') : '-'; ?>
                                        </td>
                                        <td>
                                            <?= ($row['timeIn'] && $d = DateTime::createFromFormat('H:i:s', $row['timeIn'])) ? $d->format('h:i A') : '-'; ?>
                                        </td>
                                        <td>
                                            <?= ($row['timeOut'] && $d = DateTime::createFromFormat('H:i:s', $row['timeOut'])) ? $d->format('h:i A') : '-'; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>