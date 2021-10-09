<?php
include_once('DbConnection.php');
 
class FetchEvent extends DbConnection{
 
    public function __construct(){
 
        parent::__construct();
    }


    //Events
    public function getEvents(){
 
        $sql = "SELECT * FROM tbl_event";
        $query = $this->connection->query($sql);
 
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                echo '<tr>
                        <td>'.$row['title'].'</td>
                        <td>'.$row['date_start'].' | '.$row['time_start'].'</td>
                        <td>'.$row['date_end'].' | '.$row['time_end'].'</td>
                        <td>'.$row['venue'].'</td>
                        <td>';
                            
                        if($row['status'] == 'request'){echo '<span class="badge badge-warning">';}else if($row['status'] == 'approved'){echo '<span class="badge badge-success">';}else{}
                echo    ucfirst($row['status']).'</span>
                        </td>
                        <td><a href="view-event.php?id='.$row['event_id'].'" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i> View</a></td>
                    </tr>';
            }
        }
        else{
            return false;
        }
    }
    
    //Events Details
    public function getEventDetails(){
 
        $sql = "SELECT * FROM tbl_event WHERE status = 'approved' ORDER BY event_id DESC";
        $query = $this->connection->query($sql);
 
        if($query->num_rows > 0){
            while($row = $query->fetch_assoc()){
                echo '<div class="col-lg-6">

                        <!-- Dropdown Card -->
                        <div class="card shadow mb-4" data-aos="fade-down">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">'.$row['title'].'</h6>
                                <div class="dropdown no-arrow">
                                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                        <div class="dropdown-header">Dropdown Header:</div>
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">'.
                                $row['event_desc']   
                            .'</div>
                        </div>

                    </div>';
            }
        }
        else{
            echo '<div class="col-lg-12">

                    <!-- Dropdown Card -->
                    <div class="card shadow mb-4" data-aos="fade-down">
                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">No Event</h6>
                            <div class="dropdown no-arrow">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                    <div class="dropdown-header">Dropdown Header:</div>
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">No Event for today.</div>
                    </div>

                </div>';
        }
    }

    //Event Preview Details
    public function getPreviewEventDetails(){

        $event_id = isset($_GET['id']) ? $_GET['id'] : '';

        $sql = "SELECT * FROM tbl_event WHERE event_id = '$event_id'";
        $query = $this->connection->query($sql);

        if($query->num_rows > 0){
            $row = $query->fetch_assoc();

            echo '<div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">'.$row['title'].'</h6>
                    </div>
                    <div class="card-body">
                    <p>'
                        .$row['event_desc'].
                    '</p>
                    <div class="form-group">';
                    if($row['status'] == 'request'){
                        echo '<a href="#" data-toggle="modal" data-target="#UpdateEventModal" class="btn btn-success btn-user">Approved</a>';
                    }
                    else if($row['status'] == 'approved'){
                        
                    }
                    else{
                        echo 'error';
                    }
            echo    '</div>
                    </div>
                    
                </div>';
        }
        else{
            echo '<div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Title</h6>
                    </div>
                    <div class="card-body">
                        Description
                    </div>
                </div>';
        }
    }

    public function details($sql){
 
        $query = $this->connection->query($sql);
 
        $row = $query->fetch_array();
 
        return $row;       
    }
 
    public function escape_string($value){
 
        return $this->connection->real_escape_string($value);
    }
}