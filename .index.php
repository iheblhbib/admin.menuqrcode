<?php

include('header.php');

?>
<main id="main" class="main">
  <div class="pagetitle">
    <h1>Accueil</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/"><i class="fad fa-home-lg"></i></a></li>
        <li class="breadcrumb-item active">Accueil</li>
      </ol>
    </nav>
  </div>


  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-8">
        <div class="row ">
          <div class="col-xxl-3 col-md-6">
            <div class="card info-card sales-card permalink" data-link="client">
              <div class="card-body">
                <h5 class="card-title">Clients </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fad fa-users"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $object->countClients(); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xxl-3 col-md-6">
            <div class="card info-card revenue-card  permalink" data-link="market">
              <div class="card-body">
                <h5 class="card-title">Point de vente</h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-duotone fa-burger-glass"></i>
                  </div>
                  <div class="ps-3">
                    <h6>
                      <?= $object->CountMarkets(); ?>
                    </h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card ">
              <div class="card-body">
                <h5 class="card-title">Accès total </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fa-duotone fa-qrcode"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= number_format($object->CountAccess() + $object->CountAccessQRCode(), "0", ",", " "); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xxl-3 col-md-6">
            <div class="card info-card customers-card permalink" data-link="paiement">
              <div class="card-body">
                <h5 class="card-title">Revenu total </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #dc3545;    background: #dc354547;">
                    <i class="fa-duotone fa-magnifying-glass-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= ($object->is_superadmin_user()) ?  number_format($object->totalRevenue(), "3", ",", " ") : 'N/A' ?></h6>
                  </div>
                </div>

              </div>
            </div>

          </div>

          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Statistique</h5>
                <ul class="nav nav-tabs nav-tabs-bordered" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="total-acces-tab" data-bs-toggle="tab" data-bs-target="#total-accestab" type="button" role="tab" aria-controls="total-acces" aria-selected="true">
                      Accès/Mois
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link  " id="total-jours-tab" data-bs-toggle="tab" data-bs-target="#total-jourstab" type="button" role="tab" aria-controls="total-jours" aria-selected="true">
                      Accès/Jours
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link  " id="total-market-mois-tab" data-bs-toggle="tab" data-bs-target="#total-market-moistab" type="button" role="tab" aria-controls="total-market-mois" aria-selected="true">
                      Accès/Market/Mois
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link  " id="total-market-tab" data-bs-toggle="tab" data-bs-target="#total-markettab" type="button" role="tab" aria-controls="total-market" aria-selected="true">
                      Accès/Market
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link  " id="total-annee-tab" data-bs-toggle="tab" data-bs-target="#total-anneetab" type="button" role="tab" aria-controls="total-annee" aria-selected="true">
                      Accès/Année
                    </button>
                  </li>
                </ul>
                <div class="tab-content pt-2" id="myTabContent">
                  <div class="tab-pane fade show active" id="total-accestab" role="tabpanel" aria-labelledby="total-acces-tab">
                    <div id="rapport-month"></div>
                  </div>
                  <div class="tab-pane fade " id="total-jourstab" role="tabpanel" aria-labelledby="total-jours-tab">
                    <div id="rapport-jours"></div>
                  </div>
                  <div class="tab-pane fade row" id="total-market-moistab" role="tabpanel" aria-labelledby="total-market-mois-tab">
                    <div class="col-2 text-end">
                      <input type="month" class="form-control form-control-sm" id="date-market-mois" value="<?= date('Y-m') ?>" />
                    </div>

                    <div class="col-12" id="rapport-market-mois"></div>
                  </div>
                  <div class="tab-pane fade " id="total-markettab" role="tabpanel" aria-labelledby="total-market-tab">
                    <div id="rapport-market"></div>
                  </div>
                  <div class="tab-pane fade " id="total-anneetab" role="tabpanel" aria-labelledby="total-annee-tab">
                    <div id="rapport-annee"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Dernière Feedback </h5>
                <div class="activity">
                  <div style="height: 50vh;overflow-y: auto;">
                    <?php
                    $feedbacks = json_decode($object->lastAllFeedbacks());
                    foreach ($feedbacks as $feedback => $item) {
                    ?>
                      <div class="activity-item d-flex">
                        <div class="activite-label"><?= $item->date ?></div>
                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                        <div class="activity-content">
                          <h6><?= $item->market ?> <b><?= $item->rating ?></b></h6>
                          <p> <?= $item->commentaire ?></p>
                        </div>
                      </div>
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=" col-md-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Dernière connexion <span>| Tous</span></h5>

                <div class="activity">
                  <div style="height: 50vh;overflow-y: auto;">
                    <?php
                    $Logins = json_decode($object->lastLogin());
                    foreach ($Logins as $login => $item) {
                    ?>
                      <div class="activity-item d-flex">
                        <div class="activite-label"><?= $item->date ?></div>
                        <i class='bi bi-circle-fill activity-badge text-primary align-self-start'></i>
                        <div class="activity-content">
                          <h6><b><?= $item->name ?></b></h6>
                          <p>IP : <?= $item->ip ?></p>
                        </div>
                      </div>


                    <?php
                    }
                    ?>
                  </div>

                </div>

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">

        <div class="row ">
          <div class=" col-md-6">
            <div class="card info-card sales-card permalink" data-link="client">
              <div class="card-body">
                <h5 class="card-title">Visite ce mois </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fad fa-users"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $object->CountVisite(date('Y-m-d')); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=" col-md-6">
            <div class="card info-card sales-card permalink" data-link="client">
              <div class="card-body">
                <h5 class="card-title">Visite total </h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="fad fa-users"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?= $object->CountVisite(); ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>



        <div class="card">

          <div class="card-body pb-0">
            <h5 class="card-title">Packs <span>| Total</span></h5>

            <div id="trafficChart-vente" style="min-height: 400px;" class="echart"></div>

          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Expire bientôt <span>| Tous</span></h5>

            <div class="activity">
              <div style="height: 50vh;overflow-y: auto;">
                <?php
                $accounts = json_decode($object->expiredSoon());
                foreach ($accounts as $account => $item) {
                ?>
                  <div class="activity-item d-flex">
                    <div class="activite-label"><?= $item->date ?></div>
                    <i class='bi bi-circle-fill activity-badge text-danger align-self-start'></i>
                    <div class="activity-content">
                      <h6><b><?= $item->name ?></b></h6>
                      <p>Email : <?= $item->email ?></p>
                      <p>Tél : <?= $item->num ?></p>
                    </div>
                  </div>


                <?php
                }
                ?>
              </div>

            </div>

          </div>
        </div>

      </div>

    </div>
  </section>
</main>

<?php include('footer.php'); ?>

<script>
  $.ajax({
    url: "api/pack-admin",

    method: "POST",

    dataType: "json",

    success: function(data) {
      echarts.init(document.querySelector("#trafficChart-vente")).setOption({
        tooltip: {
          trigger: 'item'
        },
        legend: {
          top: '5%',
          left: 'center'
        },
        series: [{
          name: 'Packs',
          type: 'pie',
          radius: ['40%', '70%'],
          avoidLabelOverlap: false,
          label: {
            show: false,
            position: 'center'
          },
          emphasis: {
            label: {
              show: true,
              fontSize: '18',
              fontWeight: 'bold'
            }
          },
          labelLine: {
            show: false
          },
          data: data,
          color: ['#fc8452', '#5470c6', '#91cc75', '#fac858', '#ee6666', '#73c0de', '#3ba272', '#9a60b4']
        }]
      });
    }
  });

  $.ajax({
    url: "api/rapport-annee",

    method: "POST",

    dataType: "json",

    success: function(data) {
      var x = [];
      var acces = [];
      for (var i = 0; i < data.length; i++) {
        x.push(data[i][0]);
        acces.push(data[i][1]);
      }

      new ApexCharts(document.querySelector("#rapport-annee"), {
        series: [{
          name: 'Accès',
          data: acces,
        }, ],
        chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false
          },
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        markers: {
          size: 4
        },
        colors: ['#5c7bd9'],
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          type: 'date',
          categories: x,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        }
      }).render();
    }
  });

  $.ajax({
    url: "api/rapport-month",

    method: "POST",

    dataType: "json",

    success: function(data) {
      var x = [];
      var acces = [];
      for (var i = 0; i < data.length; i++) {
        x.push(data[i][0]);
        acces.push(data[i][1]);
      }

      new ApexCharts(document.querySelector("#rapport-month"), {
        series: [{
          name: 'Accès',
          data: acces,
        }, ],
        chart: {
          height: 350,
          type: 'area',
          toolbar: {
            show: false
          },
        },
        markers: {
          size: 4
        },
        colors: ['#4154f1', '#2eca6a'],
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          type: 'date',
          categories: x,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        }
      }).render();
    }
  });

  $.ajax({
    url: "api/rapport-market",

    method: "POST",

    dataType: "json",

    success: function(data) {
      var x = [];
      var acces = [];
      for (var i = 0; i < data.length; i++) {
        x.push(data[i][0]);
        acces.push(data[i][1]);
      }

      new ApexCharts(document.querySelector("#rapport-market"), {
        series: [{
          name: 'Accès',
          data: acces,
        }, ],
        chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false
          },
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        markers: {
          size: 4
        },
        colors: ['#ee6666'],
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          type: 'date',
          categories: x,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        }
      }).render();
    }
  });

  var dateMarketMois = $('#date-market-mois').val();

  $.ajax({
    url: "api/rapport-market-mois",

    method: "POST",

    data: {
      date: dateMarketMois
    },

    dataType: "json",

    success: function(data) {
      var x = [];
      var acces = [];
      for (var i = 0; i < data.length; i++) {
        x.push(data[i][0]);
        acces.push(data[i][1]);
      }

      new ApexCharts(document.querySelector("#rapport-market-mois"), {
        series: [{
          name: 'Accès',
          data: acces,
        }, ],
        chart: {
          height: 350,
          type: 'bar',
          toolbar: {
            show: false
          },
        },
        plotOptions: {
          bar: {
            dataLabels: {
              position: 'top', // top, center, bottom
            },
          }
        },
        markers: {
          size: 4
        },
        colors: ['#ee6666'],
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          type: 'date',
          categories: x,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        }
      }).render();
    }
  });

  // Attach the onchange event to the input field with id 'date-market-mois'
  $('#date-market-mois').on('change', function() {

    $('#rapport-market-mois').html('');
    var dateMarketMois = $(this).val(); // Get the value of the input field

    // Make the AJAX call
    $.ajax({
      url: "api/rapport-market-mois",
      method: "POST",
      data: {
        date: dateMarketMois
      },
      dataType: "json",
      success: function(data) {
        var x = [];
        var acces = [];
        for (var i = 0; i < data.length; i++) {
          x.push(data[i][0]);
          acces.push(data[i][1]);
        }

        // Create the chart
        new ApexCharts(document.querySelector("#rapport-market-mois"), {
          series: [{
            name: 'Accès',
            data: acces,
          }, ],
          chart: {
            height: 350,
            type: 'bar',
            toolbar: {
              show: false
            },
          },
          plotOptions: {
            bar: {
              dataLabels: {
                position: 'top',
              },
            }
          },
          markers: {
            size: 4
          },
          colors: ['#ee6666'],
          dataLabels: {
            enabled: true,
            formatter: function(val) {
              return val;
            },
            offsetY: -20,
            style: {
              fontSize: '12px',
              colors: ["#304758"]
            }
          },
          stroke: {
            curve: 'smooth',
            width: 2
          },
          xaxis: {
            type: 'date',
            categories: x,
          },
          tooltip: {
            x: {
              format: 'dd/MM/yy'
            },
          }
        }).render();
      }
    });
  });


  $.ajax({
    url: "api/rapport-jours",

    method: "POST",

    dataType: "json",

    success: function(data) {
      var x = [];
      var acces = [];
      for (var i = 0; i < data.length; i++) {
        x.push(data[i][0]);
        acces.push(data[i][1]);
      }

      new ApexCharts(document.querySelector("#rapport-jours"), {
        series: [{
          name: 'Accès',
          data: acces,
        }, ],
        chart: {
          height: 350,
          type: 'area',
          toolbar: {
            show: false
          },
        },
        markers: {
          size: 4
        },
        colors: ['#73c0de'],
        dataLabels: {
          enabled: true,
          formatter: function(val) {
            return val;
          },
          offsetY: -20,
          style: {
            fontSize: '12px',
            colors: ["#304758"]
          }
        },
        stroke: {
          curve: 'smooth',
          width: 2
        },
        xaxis: {
          type: 'date',
          categories: x,
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy'
          },
        }
      }).render();
    }
  });
</script>