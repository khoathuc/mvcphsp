<h1>Info</h1>
<form action = "" method = "post">
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">First Name</label>
        <input name = 'firstName' value = "<?php echo $userModel['firstName']?>" type="text" class="form-control" placeholder="Tên của bạn">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">Last Name</label>
        <input name = 'lastName' value = "<?php echo $userModel['lastName']?>" type="text" class="form-control" placeholder="Họ của bạn">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">User Name</label>
        <input name = 'userName' value = "<?php echo $userModel['userName']?>" type="text" class="form-control" placeholder="Username của bạn">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">Email</label>
        <input name = 'email' value = "<?php echo $userModel['email']?>" type="email" class="form-control"placeholder="Email của bạn">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">Job Title</label>
        <input name = 'jobTitle' value = "<?php echo $userModel['jobTitle']?>" type="text" class="form-control"placeholder="Vị trí công việc">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">Avatar</label>
        <input name = 'avatar' value = "<?php echo $userModel['avatar']?>" type="file" class="form-control">
    </div>
    <div class="form-group mb-3">
        <label for="exampleInputEmail1">Company Name</label>
        <input name = 'companyName' value = "<?php echo $userModel['companyName'] ??''?>" type="text" class="form-control" placeholder="Tên Doanh Nghiệp">
    </div>
    
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php
    if($userId){
        echo '
        <button>
            <a href="/PHPMVCFramework/src/logout">Log out</a>
        </button>
        ';
    }
?>