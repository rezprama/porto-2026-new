<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/project/tifreg/login', function () {
    return view('project.tifreg.landing.login');
})->name('project.tifreg.login');

Route::get('/project/tifreg/register', function () {
    return view('project.tifreg.landing.register');
})->name('project.tifreg.register');

Route::get('/project/tifreg/dashboard', function () {
    return view('project.tifreg.feature.dashboard');
})->name('project.tifreg.dashboard');

Route::get('/project/tifreg/user-management', function () {
    return view('project.tifreg.feature.user-management');
})->name('project.tifreg.user-management');

Route::prefix('project/tifreg/master-data')->name('project.tifreg.master.')->group(function () {
    Route::get('/data-search', function () {
        return view('project.tifreg.feature.master-data.data-search');
    })->name('data-search');

    Route::get('/unit-qe', function () {
        return view('project.tifreg.feature.master-data.unit-qe');
    })->name('unit-qe');

    Route::get('/sync-metabase', function () {
        return view('project.tifreg.feature.master-data.sync-metabase');
    })->name('sync-metabase');
});

Route::prefix('project/tifreg/ne/gcu-olt')->name('project.tifreg.ne.gcu-olt.')->group(function () {
    Route::get('/monitoring', function () {
        return view('project.tifreg.feature.ne.gcu-olt.monitoring');
    })->name('monitoring');

    Route::get('/electrical', function () {
        return view('project.tifreg.feature.ne.gcu-olt.electrical');
    })->name('electrical');

    Route::get('/listing', function () {
        return view('project.tifreg.feature.ne.gcu-olt.listing');
    })->name('listing');

    Route::get('/approval', function () {
        return view('project.tifreg.feature.ne.gcu-olt.approval');
    })->name('approval');
});

Route::get('/project/tifreg/ne/material-tracking/monitoring', function () {
    return view('project.tifreg.feature.ne.material-tracking.monitoring');
})->name('project.tifreg.ne.material-tracking.monitoring');

Route::prefix('project/tifreg/ne/stock-opname')->name('project.tifreg.ne.stock-opname.')->group(function () {
    Route::get('/monitoring', function () {
        return view('project.tifreg.feature.ne.stock-opname.monitoring');
    })->name('monitoring');

    Route::get('/minimum-stock', function () {
        return view('project.tifreg.feature.ne.stock-opname.minimum-stock');
    })->name('minimum');

    Route::get('/b2b', function () {
        return view('project.tifreg.feature.ne.stock-opname.monitoring-b2b');
    })->name('b2b');
});

Route::prefix('project/tifreg/qe')->name('project.tifreg.qe.')->group(function () {
    Route::get('/list-project', function () {
        return view('project.tifreg.feature.qe.list-project');
    })->name('list-project');

    Route::get('/budget', function () {
        return view('project.tifreg.feature.qe.budget');
    })->name('budget');
});

Route::prefix('project/dalapareg')->name('project.dalapareg.')->group(function () {
    Route::get('/login', function () {
        return view('project.dalapareg.landing.login');
    })->name('login');

    Route::get('/peta-alpro', function () {
        return view('project.dalapareg.feature.peta-alpro');
    })->name('peta-alpro');

    Route::get('/daman/mapping-olt-odp', function () {
        return view('project.dalapareg.feature.daman.mapping-olt-odp');
    })->name('daman.mapping-olt-odp');

    Route::get('/assurance/rekon-material', function () {
        return view('project.dalapareg.feature.assurance.rekon-material');
    })->name('assurance.rekon-material');

    Route::get('/qe/wallboard-capex', function () {
        return view('project.dalapareg.feature.qe.wallboard-capex');
    })->name('qe.wallboard-capex');

    Route::get('/qe/monitoring', function () {
        return view('project.dalapareg.feature.qe.monitoring');
    })->name('qe.monitoring');

    Route::get('/qe/monitoring-rp', function () {
        return view('project.dalapareg.feature.qe.monitoring-rp');
    })->name('qe.monitoring-rp');

    Route::get('/qe/listing', function () {
        return view('project.dalapareg.feature.qe.listing');
    })->name('qe.listing');

    Route::get('/qe/approval-tl', function () {
        return view('project.dalapareg.feature.qe.approval-tl');
    })->name('qe.approval-tl');

    Route::get('/qe/approval-evidence', function () {
        return view('project.dalapareg.feature.qe.approval-evidence');
    })->name('qe.approval-evidence');

    Route::get('/qe/approval-qe', function () {
        return view('project.dalapareg.feature.qe.approval-qe');
    })->name('qe.approval-qe');

    Route::get('/qe/approval-regional', function () {
        return view('project.dalapareg.feature.qe.approval-regional');
    })->name('qe.approval-regional');

    Route::get('/qe/dashboard-boq', function () {
        return view('project.dalapareg.feature.qe.dashboard-boq');
    })->name('qe.dashboard-boq');

    Route::get('/qe/export-qe', function () {
        return view('project.dalapareg.feature.qe.export-qe');
    })->name('qe.export-qe');

    Route::get('/nte/stock-opname', function () {
        return view('project.dalapareg.feature.nte.stock-opname');
    })->name('nte.stock-opname');
});

Route::prefix('project/tomman')->name('project.tomman.')->group(function () {
    Route::get('/login', function () {
        return view('project.tomman.landing.login');
    })->name('login');

    Route::get('/matrix', function () {
        return view('project.tomman.feature.dispatch.matrix');
    })->name('matrix');

    Route::get('/workorder', function () {
        return view('project.tomman.feature.dispatch.monitoring');
    })->name('workorder');

    Route::get('/assurance', function () {
        return view('project.tomman.feature.assurance.index');
    })->name('assurance');

    Route::get('/ticketing/dashboard', function () {
        return view('project.tomman.feature.ticketing.dashboard');
    })->name('ticketing');

    Route::get('/leaderboards', function () {
        return view('project.tomman.feature.leaderboards.list');
    })->name('leaderboards');

    Route::get('/telegram', function () {
        return view('project.tomman.feature.telegram.broadcast');
    })->name('telegram');
});
