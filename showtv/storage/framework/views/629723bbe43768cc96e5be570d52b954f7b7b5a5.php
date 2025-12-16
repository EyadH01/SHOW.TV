<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3><i class="fas fa-play-circle"></i> إدارة الحلقات</h3>
                    <a href="<?php echo e(route('admin.episodes.create')); ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> إضافة حلقة جديدة
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>العنوان</th>
                                    <th>المسلسل</th>
                                    <th>المدة</th>
                                    <th>الإعجابات</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $episodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $episode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($episode->id); ?></td>
                                    <td><?php echo e($episode->title); ?></td>
                                    <td><?php echo e($episode->show->title); ?></td>
                                    <td><?php echo e($episode->duration); ?> دقيقة</td>
                                    <td>
                                        <span class="badge bg-success"><?php echo e($episode->likes); ?></span>
                                        <span class="badge bg-danger"><?php echo e($episode->dislikes); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.episodes.edit', $episode)); ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i> تعديل
                                        </a>
                                        <a href="<?php echo e(route('episodes.show', $episode)); ?>" class="btn btn-sm btn-info" target="_blank">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                        <form action="<?php echo e(route('admin.episodes.destroy', $episode)); ?>" method="POST" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الحلقة؟')">
                                                <i class="fas fa-trash"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <?php echo e($episodes->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/eyadhs/Downloads/SHOW.TV_f/showtv_complete/showtv/resources/views/admin/episodes/index.blade.php ENDPATH**/ ?>