<?php

include "../libs/load.php"; // Include your setup file

Session::start();
$user = Operations::getUser();

if (!Session::get('login_user')) {
    header("Location: welcome.php");
    exit;
} elseif ($user['status'] === 'not') {
    header("Location: otp_verify.php");
    exit;
} elseif (!$_GET['id']) {
    header("Location: index.php");
    exit;
}

$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    if (isset($_POST['submit'])) {
        $userId = $_GET['id'] ?? '';
        $name = $_POST['name'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $dob_day = $_POST['date'] ?? '';
        $dob_month = $_POST['month'] ?? '';
        $dob_year = $_POST['year'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $religion = $_POST['category'] ?? '';
        $caste = $_POST['caste'] ?? '';
        $mother_tongue = $_POST['mothertongue'] ?? '';
        $sub_caste = $_POST['subcategory'] ?? '';
        $profile_created_by = $_POST['pcb'] ?? '';
        $profile_img = $_FILES['profile_img'] ?? '';

        // Combine DOB
        $dob = $dob_year . '-' . str_pad($dob_month, 2, '0', STR_PAD_LEFT) . '-' . str_pad($dob_day, 2, '0', STR_PAD_LEFT);

        // You can hash the password if needed
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Assuming a User class with a register method
        $result = User::updateProfile($userId, $name, $gender, $dob, $phone, $email, $hashed_password, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by, $profile_img);
    }
}

?>

<?php include "header.php" ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Upload Area Styling */
    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 30px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        background-color: #f8f9fa;
    }

    .upload-area:hover {
        border-color: #007bff;
        background-color: #e9f5ff;
    }

    .upload-area.dragover {
        border-color: #28a745;
        background-color: #e8f5e9;
    }

    .upload-icon {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .upload-instructions {
        margin-bottom: 10px;
        color: #6c757d;
    }

    /* Image Preview Styling */
    .image-preview-container {
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    #previewImage {
        max-width: 100%;
        max-height: 200px;
        display: block;
        margin: 0 auto;
    }
</style>

<!-- main-slider-start -->
<section class="main-slider-one" style="padding: 8rem 0;">
    <div class="container">
        <form method="POST" id="landing_regForm" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="card mt-5">
                <div class="card-header text-black">
                    <div class="d-flex align-item-center justify-content-between">
                        <h4 class="mb-0">User Profile Edit</h4>
                        <p class="<?= $result ? 'text-danger' : 'text-success'; ?> text-15 mb-0"><?= $result ?></p>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Basic Information -->
                            <div class="form-group">
                                <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtName" name="name" required 
                                       placeholder="Enter Your Full Name" value="<?= $user['name'] ?>">
                                <small class="form-text text-muted">Please enter the full name of the person being registered.</small>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control" id="txtGenderMale txtGenderFemale" name="gender" required>
                                    <option value="<?= $user['gender'] ?>">Select Your Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <small class="form-text text-muted">Please select the gender of the person being registered.</small>
                            </div>

                            <div class="form-group">
                                <?php $dob = explode('-', $user['dob']); ?>
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control" id="DOBDAY" name="date" required>
                                            <option value="<?= $dob[2] ?>">DD</option>
                                            <?php for($i=1; $i<=31; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="DOBMONTH" name="month" required>
                                            <option value="<?= $dob[1] ?>">MM</option>
                                            <option value="1">Jan</option>
                                            <option value="2">Feb</option>
                                            <option value="3">Mar</option>
                                            <option value="4">Apr</option>
                                            <option value="5">May</option>
                                            <option value="6">Jun</option>
                                            <option value="7">Jul</option>
                                            <option value="8">Aug</option>
                                            <option value="9">Sep</option>
                                            <option value="10">Oct</option>
                                            <option value="11">Nov</option>
                                            <option value="12">Dec</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="DOBYEAR" name="year" required>
                                            <option value="<?= $dob[0] ?>">YYYY</option>
                                            <?php for($i=2007; $i>=1955; $i--): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                </div>
                                <small class="form-text text-muted">This information will not be visible to others.</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <!-- Contact Information -->
                            <div class="form-group">
                                <label for="txtMobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">+91</span>
                                    </div>
                                    <input type="tel" class="form-control" id="txtMobile" name="phone" 
                                           placeholder="Enter Valid Number" required value="<?= $user['phone'] ?>">
                                </div>
                                <small class="form-text text-muted">Please enter valid mobile number.</small>
                            </div>

                            <div class="form-group">
                                <label for="EMAIL" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="EMAIL" name="email" 
                                       placeholder="Enter Your Email" required value="<?= $user['email'] ?>">
                                <small class="form-text text-muted">We never share your email with 3rd parties.</small>
                            </div>

                            <div class="form-group">
                                <label for="txtcp" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txtcp" name="password" 
                                       placeholder="Enter Your Password" minlength="6" maxlength="20">
                                <small class="form-text text-muted">Password must be 6-20 characters.</small>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <!-- Cultural Background Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="Category" class="form-label">Religion <span class="text-danger">*</span></label>
                                <select class="form-control" id="Category" name="category" required>
                                    <option value="Hindu">Hindu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="txtPC" class="form-label">Caste <span class="text-danger">*</span></label>
                                <select class="form-control" id="txtPC" name="caste" required>
                                    <option value="nair" selected>Nair</option>
                                </select>
                                <small class="form-text text-muted">Please select your relationship with the person you are registering.</small>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="motherTongue" class="form-label">Mother Tongue <span class="text-danger">*</span></label>
                                <select class="form-control" id="motherTongue" name="mothertongue" required>
                                    <option value="<?= $user['mother_tongue'] ?>">Select mother tongue</option>
                                    <option value="Tamil">Tamil</option>
                                    <option value="Malayalam">Malayalam</option>
                                    <option value="Telugu">Telugu</option>
                                    <option value="English">English</option>
                                    <option value="Angika">Angika</option>
                                    <option value="Arunachli">Arunachali</option>
                                    <option value="Assamese">Assamese</option>
                                    <option value="Awadhi">Awadhi</option>
                                    <option value="Badaga">Badaga</option>
                                    <option value="Bengali">Bengali</option>
                                    <option value="Bhojpuri">Bhojpuri</option>
                                    <option value="Bihari">Bihari</option>
                                    <option value="Brij">Brij</option>
                                    <option value="Chatisgarhi">Chatisgarhi</option>
                                    <option value="Dogri">Dogri</option>
                                    <option value="French">French</option>
                                    <option value="Garhwali">Garhwali</option>
                                    <option value="Garo">Garo</option>
                                    <option value="Gujarati">Gujarati</option>
                                    <option value="Haryanvi">Haryanvi</option>
                                    <option value="Himachli/Pahari">Himachali/Pahari</option>
                                    <option value="Hindi">Hindi</option>
                                    <option value="Kanauji">Kanauji</option>
                                    <option value="Kannada">Kannada</option>
                                    <option value="Kashmiri">Kashmiri</option>
                                    <option value="Khandesi">Khandesi</option>
                                    <option value="Khasi">Khasi</option>
                                    <option value="Konkani">Konkani</option>
                                    <option value="Koshali">Koshali</option>
                                    <option value="Kumoani">Kumoani</option>
                                    <option value="Kutchi">Kutchi</option>
                                    <option value="Ladaki">Ladacki</option>
                                    <option value="Lepcha">Lepcha</option>
                                    <option value="Magahi">Magahi</option>
                                    <option value="Maithili">Maithili</option>
                                    <option value="Manipuri">Manipuri</option>
                                    <option value="Marathi">Marathi</option>
                                    <option value="Marwari">Marwari</option>
                                    <option value="Miji">Miji</option>
                                    <option value="Mizo">Mizo</option>
                                    <option value="Monpa">Monpa</option>
                                    <option value="Nepali">Nepali</option>
                                    <option value="Nicobarese">Nicobarese</option>
                                    <option value="Oriya">Oriya</option>
                                    <option value="Punjabi">Punjabi</option>
                                    <option value="Rajasthani">Rajasthani</option>
                                    <option value="Sanskrit">Sanskrit</option>
                                    <option value="Santhali">Santhali</option>
                                    <option value="Sindhi">Sindhi</option>
                                    <option value="Sourashtra">Sourashtra</option>
                                    <option value="Tripuri">Tripuri</option>
                                    <option value="Tulu">Tulu</option>
                                    <option value="Urdu">Urdu</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="SubCategory" class="form-label">Sub Caste <span class="text-danger">*</span></label>
                                <select class="form-control" id="SubCategory" name="subcategory" required>
                                    <option value="<?= $user['sub_caste'] ?>">--Select SubCaste--</option>
                                    <option value="Adiyodi">Adiyodi</option>
                                    <option value="Anthur Nair">Anthur Nair</option>
                                    <option value="Chakkala Nair">Chakkala Nair</option>
                                    <option value="Illam">Illam</option>
                                    <option value="Kaimal">Kaimal</option>
                                    <option value="Kartha">Kartha</option>
                                    <option value="Kiryathil">Kiryathil</option>
                                    <option value="Kurup">Kurup</option>
                                    <option value="Maniyani">Maniyani</option>
                                    <option value="Mannadiar">Mannadiar</option>
                                    <option value="Marar">Marar</option>
                                    <option value="Menon">Menon</option>
                                    <option value="Nair">Nair</option>
                                    <option value="Nambiar Nair">Nambiar Nair</option>
                                    <option value="Panicker">Panicker</option>
                                    <option value="Pillai">Pillai</option>
                                    <option value="Poduval">Poduval</option>
                                    <option value="Thampi">Thampi</option>
                                    <option value="Tharakan">Tharakan</option>
                                    <option value="Unnithan">Unnithan</option>
                                    <option value="Vaniya Nair">Vaniya Nair</option>
                                    <option value="Veluthedathu Nair">Veluthedathu Nair</option>
                                    <option value="Vellala Pillai">Vellala Pillai</option>
                                    <option value="Vilakithala Nair">Vilakithala Nair</option>
                                    <option value="Vellalar">Vellalar</option>
                                    <option value="Others">Others</option>
                                    <option value="Don't wish to specify">Don't wish to specify</option>
                                    <option value="Don't know my sub-caste">Don't know my sub-caste</option>
                                </select>
                            </div> 
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">  
                            <div class="form-group">
                                <label for="txtPC" class="form-label">Profile Created By <span class="text-danger">*</span></label>
                                <select class="form-control" id="txtPC" name="pcb" required>
                                    <option value="Self" selected>Self</option>
                                    <option value="Parents">Parents</option>
                                    <option value="Guardian">Guardian</option>
                                    <option value="Friends">Friends</option>
                                    <option value="Sibling">Sibling</option>
                                    <option value="Relatives">Relatives</option>
                                </select>
                                <small class="form-text text-muted">Please select your relationship with the person you are registering.</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Profile Photo Upload Section -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profile_img" class="form-label">Profile Photo</label>
                                <div class="upload-area" id="uploadArea">
                                    <div class="upload-icon">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                    </div>
                                    <p class="upload-instructions">Drag & drop your photo here or click to browse</p>
                                    <input type="file" id="profile_img" name="profile_img" accept="image/*" class="d-none">
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="browseBtn">Browse Files</button>
                                </div>
                                <small class="form-text text-muted">Max file size: 2MB. Supported formats: JPG, PNG.</small>
                            </div>
                        </div>
                        <div class="col-md-6 align-content-center">
                            <div class="image-preview-container text-center">
                                <div id="imagePreview" class="d-none">
                                    <img src="#" alt="Preview" class="img-thumbnail" id="previewImage" style="max-height: 200px;">
                                    <button type="button" class="btn btn-danger btn-sm mt-2" id="removeImageBtn">
                                        <i class="fas fa-trash-alt"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <hr> -->
                    
                    <div class="text-right mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include "footer.php" ?>

<script>
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            const uploadArea = document.getElementById('uploadArea');
            const browseBtn = document.getElementById('browseBtn');
            const fileInput = document.getElementById('profile_img');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const removeImageBtn = document.getElementById('removeImageBtn');

            // Click triggers
            browseBtn.addEventListener('click', () => fileInput.click());
            uploadArea.addEventListener('click', () => fileInput.click());

            // Drag and drop handlers
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, e => {
                    e.preventDefault();
                    e.stopPropagation();
                });
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, () => {
                    uploadArea.classList.add('dragover');
                });
            });

            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, () => {
                    uploadArea.classList.remove('dragover');
                });
            });

            // Handle dropped files
            uploadArea.addEventListener('drop', e => {
                const files = e.dataTransfer.files;
                if (files.length) {
                    previewImageFile(files[0]);
                }
            });

            // Handle file selection
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    previewImageFile(this.files[0]);
                }
            });

            // Image preview function
            function previewImageFile(file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                };
                reader.readAsDataURL(file);
            }

            // Remove selected image
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                previewImage.src = '#';
                imagePreview.classList.add('d-none');
            });

            // Basic Bootstrap form validation
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    form.classList.remove('was-validated');

                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            });

            // Phone validation
            const phoneField = document.getElementById('txtMobile');
            phoneField.addEventListener('input', function() {
                const phone = this.value.trim();
                const phoneRegex = /^[6-9]\d{9}$/;
                this.setCustomValidity(phone && !phoneRegex.test(phone) ? 'Please enter a valid 10-digit Indian mobile number starting with 6-9' : '');
            });

            // Email validation
            const emailField = document.getElementById('EMAIL');
            emailField.addEventListener('input', function() {
                const email = this.value.trim();
                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                this.setCustomValidity(email && !emailRegex.test(email) ? 'Please enter a valid email address (e.g., example@domain.com)' : '');
            });

        }, false);
    })();
</script>