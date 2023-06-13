@extends('admin')

@section('content')
    <x-admin.page-header :heading="$title"></x-admin.page-header>
    <section class="content">
        <div class="container-fluid">
            <div id="accordion">
                <div class="card">
                  <div class="card-header" id="generalSettings">
                    <h5 class="mb-0">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#general" aria-expanded="true" aria-controls="general">
                        Γενικές Ρυθμίσεις
                      </button>
                    </h5>
                  </div>
              
                  <div id="general" class="collapse show" aria-labelledby="generalSettings" data-parent="#accordion">
                    <div class="card-body">
                      <form action="{{ route('setting.save') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Τίτλος Σελίδας</label>
                                    <input type="text" name="site_name" id="inputPerPage" value="{{ $site_name }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Αποτελέσματα ανά σελίδα</label>
                                    <input type="text" name="results_per_page" id="inputPerPage" value="{{ $results_per_page }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Κατάσταση Συντήρησης</label>
                                    <div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="maintenance" value="1" {{ $maintenance ? 'checked' : null }}>Ναι 
                                            </label>
                                          </div>
                                          <div class="form-check-inline">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="maintenance" value="0" {{ !$maintenance ? 'checked' : null }}>Όχι
                                            </label>
                                          </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Text Disabled</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <input type="submit" value="ddd">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="ticketSettings">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#tickets" aria-expanded="false" aria-controls="tickets">
                        Αιτήτματα
                      </button>
                    </h5>
                  </div>
                  <div id="tickets" class="collapse" aria-labelledby="ticketSettings" data-parent="#accordion">
                    <div class="card-body">
                        <form action="">
                            <label for="inputMaintenance" class="control-label">Κατάσταση Συντήρησης</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radio1">
                                <label class="form-check-label">Radio</label>
                                <input class="form-check-input" type="radio" name="radio1">
                                <label class="form-check-label">Radio</label>
                            </div>
                        </form>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header" id="uploadSettings">
                    <h5 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#uploads" aria-expanded="false" aria-controls="uploads">
                        Διαχείριση Αρχείων
                      </button>
                    </h5>
                  </div>
                  <div id="uploads" class="collapse" aria-labelledby="uploadSettings" data-parent="#accordion">
                    <div class="card-body">
                      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                  </div>
                </div>
              </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">General Elements</h3>
                </div>

                <div class="card-body">
                    <form>
                        @method('post')
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Text</label>
                                    <input type="text" name="dasd" class="form-control" placeholder="Enter ...">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Text Disabled</label>
                                    <input type="text" class="form-control" placeholder="Enter ..." disabled="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Textarea</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Textarea Disabled</label>
                                    <textarea class="form-control" rows="3" placeholder="Enter ..." disabled=""></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="inputSuccess"><i class="fas fa-check"></i> Input with
                                success</label>
                            <input type="text" class="form-control is-valid" id="inputSuccess" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputWarning"><i class="far fa-bell"></i> Input with
                                warning</label>
                            <input type="text" class="form-control is-warning" id="inputWarning" placeholder="Enter ...">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="inputError"><i class="far fa-times-circle"></i> Input with
                                error</label>
                            <input type="text" class="form-control is-invalid" id="inputError" placeholder="Enter ...">
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                        <label class="form-check-label">Checkbox</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" checked="">
                                        <label class="form-check-label">Checkbox checked</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" disabled="">
                                        <label class="form-check-label">Checkbox disabled</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1">
                                        <label class="form-check-label">Radio</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="radio1" checked="">
                                        <label class="form-check-label">Radio checked</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" disabled="">
                                        <label class="form-check-label">Radio disabled</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Select</label>
                                    <select class="form-control">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Disabled</label>
                                    <select name="lalal" class="form-control" disabled="">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label>Select Multiple</label>
                                    <select multiple="" name="aaa" class="form-control">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Select Multiple Disabled</label>
                                    <select multiple="" class="form-control" disabled="">
                                        <option>option 1</option>
                                        <option>option 2</option>
                                        <option>option 3</option>
                                        <option>option 4</option>
                                        <option>option 5</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <input type="submit" value="dasd">
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection