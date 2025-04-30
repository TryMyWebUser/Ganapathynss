<?php

include "../libs/load.php"; // Include your setup file

Session::start();
$user = Operations::getUser();

if (Session::get('login_user'))
{
    header("Location: welcome.php");
    exit;
}

$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    if (isset($_POST['submit'])) {
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
        $result = User::register($name, $gender, $dob, $phone, $email, $hashed_password, $religion, $caste, $mother_tongue, $sub_caste, $profile_created_by, $profile_img);
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
                        <h4 class="mb-0">Register Free</h4>
                        <p class="<?= $result ? 'text-danger' : 'text-success'; ?> text-15 mb-0"><?= $result ?></p>
                        <h4 class="m-0 p-0">
                            <a href="login.php">Login</a>
                        </h4>
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Basic Information -->
                            <div class="form-group">
                                <label for="txtName" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="txtName" name="name" required 
                                       placeholder="Enter Your Full Name">
                                <small class="form-text text-muted">Please enter the full name of the person being registered.</small>
                                <div class="invalid-feedback">Please enter your name.</div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-control" id="txtGenderMale txtGenderFemale" name="gender" required>
                                    <option value="" disabled selected>Select Your Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                                <small class="form-text text-muted">Please select the gender of the person being registered.</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-4">
                                        <select class="form-control" id="DOBDAY" name="date" required>
                                            <option value="" disabled selected>DD</option>
                                            <?php for($i=1; $i<=31; $i++): ?>
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-control" id="DOBMONTH" name="month" required>
                                            <option value="" disabled selected>MM</option>
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
                                            <option value="" disabled selected>YYYY</option>
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
                                           placeholder="Enter Valid Number" required>
                                </div>
                                <small class="form-text text-muted">Please enter valid mobile number.</small>
                            </div>

                            <div class="form-group">
                                <label for="EMAIL" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="EMAIL" name="email" 
                                       placeholder="Enter Your Email" required>
                                <small class="form-text text-muted">We never share your email with 3rd parties.</small>
                            </div>

                            <div class="form-group">
                                <label for="txtcp" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="txtcp" name="password" 
                                       placeholder="Enter Your Password" minlength="6" maxlength="20" required>
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
                                    <option value="" selected>Select mother tongue</option>
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
                                    <option value="" selected>--Select SubCaste--</option>
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
                                    <input type="file" id="profile_img" name="profile_img" accept="image/*" class="d-none" required>
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
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<?php include "footer.php" ?>

<script>
    // Form validation and image upload handling
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            // Get DOM elements
            const uploadArea = document.getElementById('uploadArea');
            const browseBtn = document.getElementById('browseBtn');
            const fileInput = document.getElementById('profile_img');
            const imagePreview = document.getElementById('imagePreview');
            const previewImage = document.getElementById('previewImage');
            const removeImageBtn = document.getElementById('removeImageBtn');
            let isImageValid = false;
            
            // Click event for browse button
            browseBtn.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Click event for upload area
            uploadArea.addEventListener('click', function() {
                fileInput.click();
            });
            
            // Drag and drop events
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                uploadArea.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                uploadArea.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                uploadArea.classList.add('dragover');
            }
            
            function unhighlight() {
                uploadArea.classList.remove('dragover');
            }
            
            // Handle dropped files
            uploadArea.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length) {
                    handleFiles(files);
                }
            }
            
            // Handle selected files
            fileInput.addEventListener('change', function() {
                if (this.files.length) {
                    handleFiles(this.files);
                } else {
                    isImageValid = false;
                }
            });
            
            // Process files with comprehensive validation
            function handleFiles(files) {
                const file = files[0];
                isImageValid = false;
                
                // Reset file input if validation fails
                function resetFileInput() {
                    fileInput.value = '';
                    previewImage.src = '#';
                    imagePreview.classList.add('d-none');
                    isImageValid = false;
                }
                
                // Validate file exists
                if (!file) {
                    alert('Please select a file');
                    resetFileInput();
                    return;
                }
                
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type.toLowerCase())) {
                    alert('Please select a valid image file (JPEG, JPG, or PNG)');
                    resetFileInput();
                    return;
                }
                
                // Validate file size (2MB max)
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('File size exceeds 2MB limit');
                    resetFileInput();
                    return;
                }
                
                // Create image to check dimensions
                const img = new Image();
                const url = URL.createObjectURL(file);
                
                img.onload = function() {
                    // Validate image dimensions (optional)
                    const minWidth = 100;
                    const minHeight = 100;
                    const maxWidth = 5000;
                    const maxHeight = 5000;
                    
                    if (this.width < minWidth || this.height < minHeight) {
                        alert(`Image dimensions too small. Minimum ${minWidth}x${minHeight}px required.`);
                        URL.revokeObjectURL(url);
                        resetFileInput();
                        return;
                    }
                    
                    if (this.width > maxWidth || this.height > maxHeight) {
                        alert(`Image dimensions too large. Maximum ${maxWidth}x${maxHeight}px allowed.`);
                        URL.revokeObjectURL(url);
                        resetFileInput();
                        return;
                    }
                    
                    // If all validations pass, show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                        URL.revokeObjectURL(url);
                        isImageValid = true;
                    };
                    reader.readAsDataURL(file);
                };
                
                img.onerror = function() {
                    alert('Invalid image file');
                    URL.revokeObjectURL(url);
                    resetFileInput();
                };
                
                img.src = url;
            }
            
            // Remove image
            removeImageBtn.addEventListener('click', function() {
                fileInput.value = '';
                previewImage.src = '#';
                imagePreview.classList.add('d-none');
                isImageValid = false;
            });
            
            // Form validation
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    // Reset validation state
                    form.classList.remove('was-validated');
                    
                    // Check if image is required and validate it
                    if (fileInput.required && fileInput.files.length === 0) {
                        alert('Profile photo is required');
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }
                    
                    // Validate image if provided
                    if (fileInput.files.length > 0 && !isImageValid) {
                        alert('Please upload a valid profile photo');
                        event.preventDefault();
                        event.stopPropagation();
                        return;
                    }
                    
                    // Check other form validations
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
            
            // Validation functions
            function validatePhoneNumber(phone) {
                const phoneRegex = /^[6-9]\d{9}$/;
                return phoneRegex.test(phone);
            }

            function validateEmail(email) {
                const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                return emailRegex.test(email);
            }

            // Get the form element
            var form = document.getElementById('landing_regForm');
            var phoneField = document.getElementById('txtMobile');
            var emailField = document.getElementById('EMAIL');
            
            // Real-time validation for phone
            phoneField.addEventListener('input', function() {
                const phone = this.value.trim();
                const isValid = validatePhoneNumber(phone);
                
                if (!isValid && phone.length > 0) {
                    this.setCustomValidity('Please enter a valid 10-digit Indian mobile number starting with 6-9');
                } else {
                    this.setCustomValidity('');
                }
            });
            
            // Real-time validation for email
            emailField.addEventListener('input', function() {
                const email = this.value.trim();
                const isValid = validateEmail(email);
                
                if (!isValid && email.length > 0) {
                    this.setCustomValidity('Please enter a valid email address (e.g., example@domain.com)');
                } else {
                    this.setCustomValidity('');
                }
            });
        }, false);
    })();
</script>