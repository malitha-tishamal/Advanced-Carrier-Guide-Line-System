<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'includes/db-conn.php';

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}

// Fetch logged-in admin details
$user_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch all reports with photos
$reports_query = "SELECT r.*, rp.photo_path
                  FROM reports r
                  LEFT JOIN report_photos rp ON r.id = rp.report_id
                  ORDER BY r.created_at DESC";
$reports_result = $conn->query($reports_query);

$reports = [];
while($row = $reports_result->fetch_assoc()) {
    $reports[$row['id']][] = $row; // group photos by report_id
}

// Get report statistics safely
$stats_query = "SELECT 
    COUNT(*) AS total_reports,
    SUM(CASE WHEN priority = 'high' THEN 1 ELSE 0 END) AS `high_priority`,
    SUM(CASE WHEN priority = 'medium' THEN 1 ELSE 0 END) AS `medium_priority`,
    SUM(CASE WHEN priority = 'low' THEN 1 ELSE 0 END) AS `low_priority`
FROM reports";
$stats_result = $conn->query($stats_query);
$stats = $stats_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports - EduWide</title>
<?php include_once("includes/css-links-inc.php"); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* --- Your previous CSS here --- */
body { background: #f5f7fa; font-family: 'Segoe UI', sans-serif; }
/* Page header */
.page-header { background: linear-gradient(135deg,#1a73e8,#4285f4); color: white; padding: 20px; border-radius: 12px; margin-bottom: 25px; }
/* Filter buttons */
.filter-section { margin-bottom: 20px; }
.filter-option { padding: 8px 18px; margin: 0 5px 5px 0; border-radius: 20px; border:none; cursor: pointer; transition: 0.3s; background:#e0e0e0; }
.filter-option.active, .filter-option:hover { background:#1a73e8; color:white; }
/* Report cards */
.card.report-card { border-left: 5px solid #1a73e8; border-radius:12px; transition:0.3s; margin-bottom:20px; box-shadow:0 4px 6px rgba(0,0,0,0.05); }
.card.report-card:hover { transform: translateY(-5px); box-shadow:0 8px 15px rgba(0,0,0,0.1);}
.report-card.high { border-left-color:#ea4335; }
.report-card.medium { border-left-color:#f9ab00; }
.report-card.low { border-left-color:#34a853; }
.report-title { font-weight:600; font-size:1.1rem; color:#333; }
.report-meta { font-size:0.85rem; color:#5f6368; margin-bottom:10px; }
.report-description { font-size:0.9rem; color:#333; line-height:1.5; margin-bottom:15px; }
.report-photos img { width:70px;height:70px;border-radius:6px;object-fit:cover;margin:3px; cursor:pointer; transition:0.3s; }
.report-photos img:hover { transform: scale(1.05); }
/* Stats */
.stats-card { border-radius:12px; box-shadow:0 4px 6px rgba(0,0,0,0.05); margin-bottom:20px; }
.stat-number { font-size:2rem; font-weight:700; }
.stat-total .stat-number { color:#1a73e8; }
.stat-high .stat-number { color:#ea4335; }
.stat-medium .stat-number { color:#f9ab00; }
.stat-low .stat-number { color:#34a853; }
</style>
</head>
<body>
<?php include_once("includes/header.php"); ?>
<?php include_once("includes/sadmin-sidebar.php"); ?>

<main id="main" class="main">
    <div class="pagetitle">
        <div class="page-header">
            <h1>Reports Dashboard</h1>
            <p class="mb-0">Manage all submitted reports</p>
        </div>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                <li class="breadcrumb-item active">Reports</li>
            </ol>
        </nav>
    </div>

    <section class="section container-fluid">
        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card stats-card stat-total">
                    <div class="card-body d-flex justify-content-between">
                        <div><div class="stat-number"><?php echo $stats['total_reports'];?></div>Total Reports</div>
                        <i class="fas fa-clipboard-list fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card stat-high">
                    <div class="card-body d-flex justify-content-between">
                        <div><div class="stat-number"><?php echo $stats['high_priority'];?></div>High Priority</div>
                        <i class="fas fa-exclamation-circle fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card stat-medium">
                    <div class="card-body d-flex justify-content-between">
                        <div><div class="stat-number"><?php echo $stats['medium_priority'];?></div>Medium Priority</div>
                        <i class="fas fa-minus-circle fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card stat-low">
                    <div class="card-body d-flex justify-content-between">
                        <div><div class="stat-number"><?php echo $stats['low_priority'];?></div>Low Priority</div>
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section mb-4">
            <h5>Filters</h5>
            <button class="filter-option active" data-filter="all">All</button>
            <button class="filter-option" data-filter="today">Today</button>
            <button class="filter-option" data-filter="yesterday">Yesterday</button>
            <button class="filter-option" data-filter="tomorrow">Tomorrow</button>
            <button class="filter-option" data-filter="high">High</button>
            <button class="filter-option" data-filter="medium">Medium</button>
            <button class="filter-option" data-filter="low">Low</button>
        </div>

        <!-- Reports -->
        <div class="row" id="reports-container">
            <?php if(!empty($reports)): ?>
                <?php foreach($reports as $report_id => $report_group): 
                    $report = $report_group[0]; 
                    $priority_class = strtolower($report['priority']);
                    $report_date = date('Y-m-d', strtotime($report['report_date']));
                ?>
                    <div class="col-xl-4 col-lg-6 mb-4 report-item <?php echo $priority_class; ?>" 
                         data-priority="<?php echo $priority_class;?>" 
                         data-date="<?php echo $report_date;?>">
                        <div class="card report-card <?php echo $priority_class;?>">
                            <div class="card-body">
                                <h5 class="report-title"><?php echo htmlspecialchars($report['report_title']); ?></h5>
                                <div class="report-meta"><?php echo date('M d, Y', strtotime($report['report_date'])); ?> | <?php echo htmlspecialchars($report['reporter_name']);?></div>
                                <div class="report-description"><?php echo htmlspecialchars(substr($report['description'],0,120)).'...';?></div>
                                <?php if(!empty($report_group[0]['photo_path'])): ?>
                                    <div class="report-photos">
                                        <?php foreach($report_group as $photo): ?>
                                            <img src="uploads/reports/<?php echo $photo['photo_path'];?>" alt="photo" data-bs-toggle="modal" data-bs-target="#photoModal" data-photo-src="uploads/reports/<?php echo $photo['photo_path'];?>">
                                        <?php endforeach;?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5"><h4>No reports found</h4></div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include_once("includes/footer.php"); ?>
<?php include_once("includes/js-links-inc.php"); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const filterBtns = document.querySelectorAll('.filter-option');
    const reports = document.querySelectorAll('.report-item');

    filterBtns.forEach(btn=>{
        btn.addEventListener('click', function(){
            filterBtns.forEach(b=>b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            const today = new Date().toISOString().slice(0,10);
            const yesterday = new Date(new Date().setDate(new Date().getDate()-1)).toISOString().slice(0,10);
            const tomorrow = new Date(new Date().setDate(new Date().getDate()+1)).toISOString().slice(0,10);

            reports.forEach(r=>{
                const rdate = r.getAttribute('data-date');
                const rpriority = r.getAttribute('data-priority');

                if(filter==='all'){ r.style.display='block'; }
                else if(filter==='today'){ r.style.display=(rdate===today)?'block':'none'; }
                else if(filter==='yesterday'){ r.style.display=(rdate===yesterday)?'block':'none'; }
                else if(filter==='tomorrow'){ r.style.display=(rdate===tomorrow)?'block':'none'; }
                else{ r.style.display=(rpriority===filter)?'block':'none'; }
            });
        });
    });

    // Photo modal
    const photoModal = document.getElementById('photoModal');
    if(photoModal){
        photoModal.addEventListener('show.bs.modal', function(event){
            const btn = event.relatedTarget;
            const src = btn.getAttribute('data-photo-src');
            document.getElementById('modalPhoto').src = src;
        });
    }
});
</script>

<!-- Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalPhoto" src="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
</body>
</html>
