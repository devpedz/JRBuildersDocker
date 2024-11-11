<?php require_once 'header.php';
global $db;
global $session;
$userId = $session->get('user_data')['id'];
$db->query("SELECT display_name,email FROM users WHERE id = $userId");
$user = json_decode(json_encode($db->single()));
?>


<style>
    /* Hide search input */
    .dt-search {
        display: none;
    }

    /* Style for error messages */
    .invalid-feedback {
        color: #dc3545;
        /* Red color */
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 80%;
    }

    #camera {
        z-index: 0;
        margin-right: auto;
        margin-left: auto;
        max-height: 200px;
        max-width: 300px;
        height: 200x;
        /* border: 1px solid black; */
    }

    #camera video {
        margin-right: auto;
        margin-left: -25px;
        border: 1px solid white;
        border-radius: 25px;

        max-width: 350px;
        height: 200px !important;
    }



    .captured-image {
        margin: 5px;
    }

    /* Styles for overlay */
    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Semi-transparent black */
        z-index: 9999;
        /* Ensure it's above other elements */
    }

    /* Styles for loading spinner */
    #spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
    }
</style>
<div class="page-body">
    <div id="overlay">
        <div id="spinner">
            <!-- You can replace this with any loading animation or text -->
            Loading...
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Transactions</h4>
                    </div>
                    <!--Extra large modal-->
                    <div id="modalTransaction" class="modal fade bd-example-modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">New Transaction</h4>
                                    <button onclick="$('#form')[0].reset();$('#form').removeClass('was-validated');" class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="form" class="needs-validation custom-input" novalidate="">
                                    <div class="row g-3 modal-body dark-modal">

                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="transaction_date">Transaction Date</label>
                                            <input class="form-control" id="transaction_date" type="text" placeholder="Enter Transaction Date" name="transaction_date" required="">
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="cv_no">CV NO</label>
                                            <input class="form-control" id="cv_no" type="text" placeholder="Enter CV No" name="cv_no" required="">
                                        </div>
                                        <div class="col-md-4 position-relative">
                                            <label class="form-label" for="category">Category</label>
                                            <input id="category" name="category" class="selectMode badge-light-primary" placeholder="Please select category" required>
                                            <div class="invalid-tooltip">Please choose category.</div>
                                        </div>
                                        <div class="col-md-3 position-relative">
                                            <label class="form-label" for="transaction_type">Type</label>
                                            <select class="form-select" id="transaction_type" name="transaction_type" required="">
                                                <option value="" disabled selected>Select Transaction Type</option>
                                                <option value="IN">IN</option>
                                                <option value="OUT" selected>OUT</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 position-relative">
                                            <label class="form-label" for="amount">Amount</label>
                                            <input class="form-control" id="amount" type="text" placeholder="Enter Amount" name="amount" required="">
                                        </div>
                                        <div class="col-md-6 position-relative">
                                            <label class="form-label" for="description">Description</label>
                                            <input class="form-control" id="description" type="text" placeholder="Enter Description" name="description" required="">
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-lg-6">
                                                <div class="position-relative">
                                                    <div id="camera" class="">

                                                    </div>
                                                    <div class="text-center pt-2">
                                                        <button type="button" id="capture-btn" class="btn btn-sm btn-round btn-dark rounded-5"><i class="fa fa-camera"></i> </button>
                                                        <button type="button" id="clear-capture" class="btn btn-sm btn-danger rounded-5"><i class="fa fa-trash"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="cameraSelection" class="form-label">Camera Setup</label>
                                                <div id="cameraSelection"></div>
                                            </div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-lg-12 mb-3">

                                            </div>
                                        </div>
                                        <div id="captured-images">
                                            <ul id="images" class="images">

                                            </ul>
                                        </div>
                                        <div class="row my-gallery gallery" id="aniimated-thumbnials" itemscope="">

                                        </div>
                                        1
                                    </div>
                                    <div class="modal-footer">
                                        <div class="col-12">
                                            <button id="btnSubmit" class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="pswp__bg"></div>
                        <div class="pswp__scroll-wrap">
                            <div class="pswp__container">
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                                <div class="pswp__item"></div>
                            </div>
                            <div class="pswp__ui pswp__ui--hidden">
                                <div class="pswp__top-bar">
                                    <div class="pswp__counter"></div>
                                    <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
                                    <button class="pswp__button pswp__button--share" title="Share"></button>
                                    <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
                                    <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
                                    <div class="pswp__preloader">
                                        <div class="pswp__preloader__icn">
                                            <div class="pswp__preloader__cut">
                                                <div class="pswp__preloader__donut"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                    <div class="pswp__share-tooltip"></div>
                                </div>
                                <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
                                <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
                                <div class="pswp__caption">
                                    <div class="pswp__caption__center"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-product-header">
                            <div>
                                <div class="light-box"><a data-bs-toggle="collapse" href="#collapseProduct" role="button" aria-expanded="false" aria-controls="collapseProduct"><i class="filter-icon show" data-feather="filter"></i><i class="icon-close filter-close hide"></i></a></div>
                                <button id="btnNew" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-xl"><i class="fa fa-plus"></i>&nbsp;New Transaction</button>
                            </div>
                            <div class="collapse" id="collapseProduct">
                                <div class="card card-body list-product-body">
                                    <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-2 g-3">
                                        <div class="col-xl-4 position-relative">
                                            <input id="searchReference" class="form-control" type="text" placeholder="Enter Reference #" required="" oninput="dataTable.column(0).search(this.value).draw()">
                                        </div>
                                        <div class="col-xl-4 position-relative">
                                            <input id="searchCV" class="form-control" type="text" placeholder="Enter CV #" required="" oninput="dataTable.column(1).search(this.value).draw()">
                                        </div>
                                        <div class="col-xl-4 position-relative">
                                            <input id="searchCategory" class="selectMode badge-light-primary" placeholder="Please select category">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive theme-scrollbar">
                            <table id="datatable" class="display" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Reference#</th>
                                        <th>CV#</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
<?php require_once 'footer.php'; ?>

<script>
    // Initialize PhotoSwipe
    var initPhotoSwipeFromDOM = function(gallerySelector) {
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes;
            var numNodes = thumbElements.length;
            var items = [];
            var figureEl;
            var linkEl;
            var size;
            for (var i = 0; i < numNodes; i++) {
                figureEl = thumbElements[i]; // <figure> element
                // include only element nodes
                if (figureEl.nodeType !== 1) {
                    continue;
                }
                linkEl = figureEl.children[0]; // <a> element
                size = linkEl.getAttribute('data-size').split('x');
                // create slide object
                var item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };
                if (figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }
                if (linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }
                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }
            return items;
        };

        var closest = function closest(el, fn) {
            return el && (fn(el) ? el : closest(el.parentNode, fn));
        };

        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;
            var eTarget = e.target || e.srcElement;
            var clickedListItem = closest(eTarget, function(el) {
                return el.tagName && el.tagName.toUpperCase() === 'FIGURE';
            });
            if (!clickedListItem) {
                return;
            }
            var clickedGallery = clickedListItem.parentNode;
            var childNodes = clickedListItem.parentNode.childNodes;
            var numChildNodes = childNodes.length;
            var nodeIndex = 0;
            var index;
            for (var i = 0; i < numChildNodes; i++) {
                if (childNodes[i].nodeType !== 1) {
                    continue;
                }
                if (childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }
            if (index >= 0) {
                openPhotoSwipe(index, clickedGallery);
            }
            return false;
        };

        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1);
            var params = {};
            if (hash.length < 5) { // pid=1
                return params;
            }
            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if (!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if (pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }
            if (params.gid) {
                params.gid = parseInt(params.gid, 10);
            }
            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0];
            var gallery;
            var options;
            var items;
            items = parseThumbnailElements(galleryElement);
            // define options (if needed)
            options = {
                index: index,
                bgOpacity: 0.9,
                showHideOpacity: true
            };
            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll(gallerySelector);
        for (var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i + 1);
            galleryElements[i].onclick = onThumbnailsClick;
        }
        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if (hashData.pid && hashData.gid) {
            openPhotoSwipe(parseInt(hashData.pid, 10) - 1, galleryElements[hashData.gid - 1], true, true);
        }
    };
</script>
<script>
    "use strict";

    // Form validation and submission
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();


    // Extend jQuery with localStorage functionality
    $.extend({
        localStorage: function(key, value) {
            if (arguments.length === 1) {
                // Get item from localStorage
                return localStorage.getItem(key);
            } else {
                // Set item in localStorage
                localStorage.setItem(key, value);
            }
        }
    });
    // Input formatting
    var amount = new Cleave("#amount", {
        numeral: true
    });
    var description = new Cleave("#description", {
        uppercase: true,
        blocks: [0, 9999],
        delimiter: ''
    });
    var cv_no = new Cleave('#cv_no', {
        numeral: true,
        numeralThousandsGroupStyle: 'none'
    });

    // DataTable initialization
    var dataTable = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        orderable: false,
        // "searching": false,
        ajax: {
            "url": "api/getTransactions/",
            "type": "POST",
            "data": {
                email: '<?= $user->email ?>'
            }
        },
        columns: [{
                "data": null,
                "render": function(data, type, row) {
                    const parsedDate = new Date(row.transaction_date);
                    const formattedDate = parsedDate.toLocaleString('en-US', {
                        month: 'long',
                        day: 'numeric',
                        year: 'numeric',
                    });

                    return formattedDate;

                }
            },
            {
                "data": "reference_no",
                "render": function(data, type, row) {
                    return `<a class="" href="javascript:void(0);" onclick="showTransaction('${row.reference_no}')">${row.reference_no}</a>`;
                }
            },
            {
                "data": "cv_no"
            },

            {
                "data": "category_id",
                "render": function(data, type, row) {
                    return `<span>${row.category_name}</span>`;

                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return `<span class="d-inline-block text-truncate" style="max-width: 350px;" tabindex="0" data-bs-container="body" data-bs-toggle="popover" data-bs-placement="top" title="${row.description}">${row.description}</span>`
                    // return `<span  class="d-inline-block text-truncate" >${row.description}</span>`
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    if (row.transaction_type === 'IN') {
                        return `<span class="badge bg-success text-white me-2">IN</span>`
                    } else {
                        return `<span class="badge bg-danger text-white me-2">OUT</span>`
                    }
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    return row.amount.toLocaleString();
                }
            },
            {
                "data": null,
                "render": function(data, type, row) {
                    if (type === 'display') {
                        return $.ajax({
                            url: '/api/getBalance',
                            method: 'POST',
                            data: {
                                id: row.id,
                                email: '<?= $user->email ?>'
                            }, // Pass any necessary data to the server
                            async: false // Ensure synchronous execution to return the value
                        }).responseText;
                    }
                    return data;
                }
            },
            {
                "data": "id",
                "render": function(data, type, row) {
                    return `<button class="btn btn-dark btn-sm cancelTransaction" value="${row.id}"><i class="fa-solid fa-xmark"></i>&nbsp;cancel</button>`;
                }
            },

        ]
    });

    // Tagify initialization and event handling
    var searchCategory = new Tagify(document.getElementById('searchCategory'), {
        enforceWhitelist: true,
        mode: "select",
        whitelist: [],
        blacklist: ["foo", "bar"],
        dropdown: {
            enabled: 0
        }
    });
    var category = new Tagify(document.getElementById('category'), {
        enforceWhitelist: true,
        mode: "select",
        whitelist: [], // This will be populated with data fetched from the server
        blacklist: ["foo", "bar"],
        dropdown: {
            enabled: 0 // disabling the dropdown
        }
    });

    ajax("/api/getCategory", {
        id: <?= $userId ?>
    }).then(data => {
        console.log(data);
        searchCategory.settings.whitelist = data;
        category.settings.whitelist = data;
        category.update();
        searchCategory.update();
        searchCategory.on("change", function(e) {
            const json = (isValidJSON(e.detail.value)) ? $.parseJSON(e.detail.value) : false;
            if (json) {
                dataTable.column(3).search(json[0].id).draw();
            } else {
                dataTable.column(3).search('').draw();
            }
        });
    });
    //fetch Category
    // $.post("/api/getCategory", {
    //         id: <?= $userId ?>
    //     },
    //     function(data) {
    //         searchCategory.settings.whitelist = data;
    //         category.settings.whitelist = data;
    //         category.update();
    //         searchCategory.update();
    //         searchCategory.on("change", function(e) {
    //             const json = (isValidJSON(e.detail.value)) ? $.parseJSON(e.detail.value) : false;
    //             if (json) {
    //                 dataTable.column(3).search(json[0].id).draw();
    //             } else {
    //                 dataTable.column(3).search('').draw();
    //             }
    //         });
    //     },
    //     "json"
    // );

    // filter option
    const listItems = document.querySelectorAll(".light-box");
    listItems.forEach(function(item) {
        const envelope_1 = item.querySelector(".filter-icon");
        const envelope_2 = item.querySelector(".filter-close");
        item.addEventListener("click", function() {
            $('#searchReference').val('').change();
            $('#searchCV').val('').change();
            dataTable.column(0).search('').draw();
            dataTable.column(1).search('').draw();
            dataTable.column(3).search('').draw();
            if (searchCategory) {
                searchCategory.removeAllTags();
            }
            if (envelope_1) {
                envelope_1.classList.toggle("show");
                envelope_2.classList.toggle("hide");
            }
            if (envelope_2) {
                envelope_1.classList.toggle("hide");
                envelope_2.classList.toggle("show");
            }
        });
    });
    var capturedImages = [];

    // Camera integration and image capture
    $(document).ready(function() {
        // Function to save a single image
        function saveImage(data_uri, index, id) {
            return new Promise((resolve, reject) => {
                const xhr = new XMLHttpRequest();
                xhr.open('POST', '/api/saveAttachments', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status ===
                            200) {
                            console.log('Image ' + index + ' saved:', xhr.responseText);
                            resolve(); // Resolve the promise
                        } else {
                            reject('Failed to save image ' + index + ': ' + xhr.status); // Reject the promise
                        }
                    }
                };
                xhr.send('id=' + id + '&image=' + encodeURIComponent(data_uri));
            });
        }

        // Function to save all images sequentially
        function saveAllImages(id) {
            // console.log(id);
            const promises = [];
            capturedImages.forEach((data_uri, index) => {
                const promise = saveImage(data_uri, index, id);
                promises.push(promise);
            });

            // Return a combined promise
            return Promise.all(promises);
        }

        // Start saving all images
        if (capturedImages.length > 0) {
            saveAllImages()
                .then(() => {
                    unblockUI();
                    console.log('All images saved successfully.');
                })
                .catch(() => {
                    console.error('Failed to save all images.');
                });
        } else {
            unblockUI();
            console.warn('No images to save.');
        }

        Webcam.set({
            width: 1280,
            height: 720,
            image_format: "jpeg",
            jpeg_quality: 90,
            force_flash: false,
            fps: 45
        });

        Webcam.set("constraints", {
            optional: [{
                minWidth: 600
            }]
        });
        if ($.localStorage('cameraId')) {
            Webcam.set("constraints", {
                deviceId: $.localStorage('cameraId') ? {
                    exact: $.localStorage('cameraId')
                } : undefined,
                facingMode: 'user',
                width: 1280,
                height: 720,
            });
        }
        Webcam.attach('#camera');
        // Function to populate camera selection dropdown
        function populateCameraDropdown() {
            var select = document.createElement('select');
            select.classList.add('form-select')
            select.id = 'cameraSelector';

            navigator.mediaDevices.enumerateDevices()
                .then(function(devices) {
                    var cameras = devices.filter(function(device) {
                        return device.kind === 'videoinput';
                    });

                    cameras.forEach(function(camera, index) {
                        var option = document.createElement('option');
                        option.value = camera.deviceId;
                        option.text = camera.label || 'Camera ' + (index + 1);
                        option.selected = $.localStorage('cameraId') === camera.deviceId ? true : false,
                            select.appendChild(option);
                    });

                    document.getElementById('cameraSelection').appendChild(select);

                    // Attach webcam to the default camera

                    // Add event listener to change camera when selection changes
                    select.addEventListener('change', function(event) {
                        var cameraId = event.target.value;
                        $.localStorage('cameraId', cameraId);
                        Webcam.set({
                            width: 1280,
                            height: 720,
                            image_format: "jpeg",
                            jpeg_quality: 90,
                            force_flash: false,
                            fps: 45
                        });

                        Webcam.set("constraints", {
                            deviceId: $.localStorage('cameraId') ? {
                                exact: $.localStorage('cameraId')
                            } : undefined,
                            facingMode: 'user',
                            width: 1280,
                            height: 720,
                        });
                        Webcam.reset();
                        Webcam.attach("#camera");
                    });
                })
                .catch(function(err) {
                    console.error('Error getting media devices: ', err);
                });
        }

        // Populate camera dropdown and attach webcam once
        populateCameraDropdown();

        // Form submission via AJAX
        $("#form").submit(function(e) {
            e.preventDefault(); // Prevent default form submission
            if (this.checkValidity()) {
                (async () => {
                    try {
                        $('#modalTransaction').modal('hide');
                        // blockUI();
                        const result = await $.ajax({
                            url: '/api/addTransaction',
                            method: 'POST',
                            data: $(this).serialize(),
                        });
                        // saveAllImages(result.refNo);
                        const data = JSON.parse(result);
                        if (data.status == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Transaction has been added!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((result) => {
                                if (result.dismiss === Swal.DismissReason.timer || result.isDismissed) {
                                    window.location.reload(); // Reload the window
                                }
                            });
                            // Handle successful submission
                        } else {
                            // Handle submission failure
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                })();
            }
        });

        $(document).on('click', '.cancelTransaction', function() {
            const currentRow = $(this).closest('tr');
            // Find the value in the second column of the current row
            const refNo = currentRow.find('td:eq(1)').text();

            // Do something with the value, for example, log it to console
            swal({
                title: "Are you sure you want to cancel the transaction?",
                text: "This action cannot be undone.",
                icon: "warning",
                buttons: ["No, Keep Transaction", "Yes, Cancel Transaction"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal({
                        title: "Verify Your Password",
                        icon: "/assets/images/password100px.png",
                        content: {
                            element: "input",
                            attributes: {
                                type: "password",
                            },
                        },
                    }).then((password) => {
                        ajax('api/verify', {
                            password: password
                        }).then(response => {
                            if (response.ok) {
                                ajax('api/cancelTransaction', {
                                    transactionId: this.value
                                }).then(response => {
                                    if (response.ok) {
                                        swal({
                                            title: "Transaction Cancelled",
                                            text: `Ref#${refNo}`,
                                            icon: "success"
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    }
                                });
                            } else {
                                swal("Error!", "Incorrect password.", "error");
                            }
                        }).catch(error => {
                            // Handle errors
                            swal("Error!", "An error occurred while verifying the password.", "error");
                            console.error('Error:', error);
                        });;
                    });
                }
            });
        });
    });


    // Set item in localStorage using jQuery

    //Button Functions
    $('#btnNew').click(function(e) {
        if ($.localStorage('cameraId')) {
            $('#cameraSelector').val($.localStorage('cameraId')).change();
        }
        if (capturedImages) {
            capturedImages = [];
        }
        $('#aniimated-thumbnials').html("");
        const currentDate = new Date();
        // Initialize Flatpickr with default value set to current date and time
        flatpickr("#transaction_date", {
            enableTime: true,
            dateFormat: 'Y-m-d H:i:S',
            time_24hr: false,
            enableSeconds: true,
            defaultDate: currentDate, // Set default date to today
        });
        e.preventDefault();
    });
    $(document).on('click', '#capture-btn', function() {
        Webcam.snap(function(data_uri) {
            capturedImages.push(data_uri);
            displayCapturedImage(data_uri);
        });
    });
    $(document).on('click', '#clear-capture', function() {
        $('#aniimated-thumbnials').html("");
        capturedImages = [];
    });

    //functions
    async function ajax(url, params) {
        try {
            const response = await $.post(url, params);
            try {
                return JSON.parse(response); // Return data upon success
            } catch (error) {
                return response;
            }
        } catch (error) {
            console.error('Error fetching data:', error);
            throw error; // Rethrow the error to be caught by the caller
        }
    }

    function blockUI() {
        // Show overlay and spinner
        $('#overlay').show();
        // Block the UI
        $.blockUI({
            message: null
        });
    }

    // Function to unblock UI
    function unblockUI() {
        // Hide overlay and spinner
        $('#overlay').hide();
        // Unblock the UI
        $.unblockUI();
    }

    function displayCapturedImage(dataUri) {
        var append = `
            <figure class="col-md-3 col-6 img-hover hover-12" itemprop="associatedMedia" itemscope="">
                    <a href="${dataUri}" itemprop="contentUrl" data-size="1600x950">
                        <div><img src="${dataUri}" itemprop="thumbnail" alt="Image description"></div>
                    </a>
                <figcaption itemprop="caption description">Attachment ${capturedImages.length}</figcaption>
           </figure>
           `;
        $(".my-gallery").append(append);
        initPhotoSwipeFromDOM('.my-gallery');
    }


    // Utility function to check if a string is valid JSON
    function isValidJSON(jsonString) {
        try {
            JSON.parse(jsonString);
            return true;
        } catch (error) {
            return false;
        }
    }
</script>