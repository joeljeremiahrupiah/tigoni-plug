<template>
    <div id="admin_dashboard">
        <div class="container-xl">
            <!-- Page title -->
            <div class="page-header d-print-none">
                <div class="row align-items-center">
                    <div class="col">
                        <!-- Page pre-title -->
                        <div class="page-pretitle">
                            Overview
                        </div>
                        <h2 class="page-title">
                            Dashboard
                        </h2>
                    </div>
                    <!-- Page title actions -->
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <span class="d-none d-sm-inline">
                                <a href="#" class="btn btn-white">
                                    New view
                                </a>
                            </span>
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                                Create new report
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-report" aria-label="Create new report">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <line x1="12" y1="5" x2="12" y2="19" />
                                    <line x1="5" y1="12" x2="19" y2="12" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Vendors</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3">75</div>
                                <div class="d-flex mb-2">
                                    <div>Conversion rate</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            7%
                                        </span>
                                    </div>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-blue" style="width: 75%" role="progressbar"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <span class="visually-hidden">75% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Active Users</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3">75</div>
                                <div class="d-flex mb-2">
                                    <div>Joining rate</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            7%
                                        </span>
                                    </div>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-blue" style="width: 75%" role="progressbar"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <span class="visually-hidden">75% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Impressions</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3">75</div>
                                <div class="d-flex mb-2">
                                    <div>Impressions rate</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            7%
                                        </span>
                                    </div>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-blue" style="width: 75%" role="progressbar"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <span class="visually-hidden">75% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="subheader">Total Products</div>
                                    <div class="ms-auto lh-1">
                                        <div class="dropdown">
                                            <a class="dropdown-toggle text-muted" href="#" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item active" href="#">Last 7 days</a>
                                                <a class="dropdown-item" href="#">Last 30 days</a>
                                                <a class="dropdown-item" href="#">Last 3 months</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="h1 mb-3">75</div>
                                <div class="d-flex mb-2">
                                    <div>Product adittion rate</div>
                                    <div class="ms-auto">
                                        <span class="text-green d-inline-flex align-items-center lh-1">
                                            7%
                                        </span>
                                    </div>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-blue" style="width: 75%" role="progressbar"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        <span class="visually-hidden">75% Complete</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup></script>