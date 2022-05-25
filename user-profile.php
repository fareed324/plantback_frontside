<?php include 'header2.php'; ?>
    <section class="pt-135 pb-5">
      <div class="container rounded bg-white mt-5 mb-5">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-3 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3"><img class="rounded-circle mt-5" src="images/users.jpg"><span class="font-weight-bold">Amelly</span><span class="text-black-50">amelly12@bbb.com</span><span> </span></div>
            </div>
            <div class="col-sm-12 col-md-8 col-lg-5 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6"><label class="labels">Name</label><input type="text" class="form-control" placeholder="first name" value=""></div>
                        <div class="col-md-6"><label class="labels">Surname</label><input type="text" class="form-control" value="" placeholder="surname"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><label class="labels">PhoneNumber</label><input type="text" class="form-control" placeholder="enter phone number" value=""></div>
                        <div class="col-md-12"><label class="labels">Address</label><input type="text" class="form-control" placeholder="enter address" value=""></div>
                        <div class="col-md-12"><label class="labels">Email ID</label><input type="text" class="form-control" placeholder="enter email id" value=""></div>
                        <div class="col-md-12"><label class="labels">Education</label><input type="text" class="form-control" placeholder="education" value=""></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6"><label class="labels">Country</label><input type="text" class="form-control" placeholder="country" value=""></div>
                        <div class="col-md-6"><label class="labels">State/Region</label><input type="text" class="form-control" value="" placeholder="state"></div>
                    </div>
                    <div class="mt-5 text-center"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="p-3 py-5" style="background: #f6f6f6;">
                    <div class="d-flex justify-content-between align-items-center experience"><span>Add Location</span></div><br>
                    <div class="col-md-12">
                        <span class="labels">Choose file(s)</span>
                        <p><input id="files-upload" type="file" multiple></p>
                        <div id="notice" class="notice"></div>
                        <div id="container" class="image_container">
                             <div id="inner_container"></div>
                        </div>
                    </div>
                    <div class="col-md-12 pt-4"><label class="labels">Name of Location</label><input type="text" class="form-control" placeholder="Location" value=""></div> <br>
                    <div class="col-md-12">
                      <label for="exampleFormControlTextarea1" class="form-label labels mb-0">Description</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>
                    <div class="col-md-12">
                    <button type="button" class="btn btn-primary profile-button mt-4">Add Location</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </section>
    <?php include 'footer.php'; ?>