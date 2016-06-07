<?php
class UltimaHoraController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->beforeFilter('auth');
    }

    public function getIndex()
    {
        $user_id = [];
        $user_uh = [];
        $sites_user = [];
        $user_id = Session::get('user.id');
        $user_uh = Usersuh::where('user_id', $user_id)->first();
        if ($user_uh != null) {
            $sites_user = json_decode($user_uh->sites);
        }
        foreach ($sites_user as &$site_user) {
            $site_user = Sitesuh::select('id', 'abrev', 'site')->where('id', $site_user)->first();
        }
        return View::make('ultimahora.index')->with('sites_user', $sites_user);
    }

    public function getUsers()
    {
        $datos = [];
        $users = [];
        $users_uh = [];
        $sites = [];
        $users = User::select(['id', 'first_name', 'last_name', 'email'])->get();
        $users_uh = Usersuh::select()->get();
        $sites = Sitesuh::select('id', 'abrev', 'site')->get();
        foreach ($users_uh as $key => $user_uh) {
            $sites_user = json_decode($user_uh->sites);
            foreach ($sites_user as &$site) {
                $site = Sitesuh::select('id', 'abrev', 'site')->where('id', $site)->first();
            }
            $datos[] = ['user_id' => $user_uh->user_id, 'email' => $user_uh->touser->email, 'sites' => $sites_user];
        }
        return View::make('ultimahora.users')->with('datos', $datos)->with('users', $users)->with('sites', $sites);
    }

    public function postUsers()
    {
        $sites = [];
        $dato = Input::all();
        if (Request::ajax()) {
            $email = $dato['email'];
            $user = User::select('id', 'email', 'first_name', 'last_name')->where('email', $email)->first();
            $first_name = Crypt::decrypt($user->first_name);
            $last_name = Crypt::decrypt($user->last_name);
            $user_id = $user->id;
            $user_uh = Usersuh::select('sites')->where('user_id', $user_id)->first();
            if ($user_uh) {
                $sites = json_decode($user_uh->sites);
                foreach ($sites as &$valor) {
                    $valor = Sitesuh::select('id', 'abrev', 'site')->where('id', $valor)->first();
                }
            }
            return Response::json(['first_name' => $first_name, 'last_name' => $last_name, 'user_id' => $user_id, 'sites' => $sites]);
        } else {
            $rules = ['sites' => 'required', 'user_id' => 'required'];
            $messages = ['sites.required' => "Debes seleccionar al menos un sitio", 'user_id.required' => "No seleccionaste un usuario"];
            $validator = Validator::make($dato, $rules, $messages);
            if ($validator->fails()) {
                $user_id = Input::get('user_id');
                if ($user_id) {
                    $user = User::select('id', 'email', 'first_name', 'last_name')->where('id', $user_id)->first();
                    $first_name = Crypt::decrypt($user->first_name);
                    $last_name = Crypt::decrypt($user->last_name);
                    $miuser = ['email' => $user->email, 'first_name' => $first_name, 'last_name' => $last_name];
                    Session::flash('miuser', $miuser);
                }
                return Redirect::back()->withErrors($validator->messages())->withInput();
            } else {
                $sites = json_encode($dato['sites']);
                $user_id = $dato['user_id'];
                $user_uh = Usersuh::where('user_id', $user_id)->first();
                if ($user_uh == null) {
                    $user = new Usersuh;
                    $user->user_id = $user_id;
                    $user->sites = $sites;
                    $user->save();
                    Session::flash('message', 'Se han otorgado permisos en los Sitios seleccionados!');
                    return Redirect::back();
                } else {
                    $user = Usersuh::find($user_uh->id);
                    $user->sites = $sites;
                    $user->save();
                    Session::flash('message', 'Los Sitios se han actualizado!');
                    return Redirect::back();
                }
            }
        }
    }

    public function postUserDelete()
    {
        $dato = Input::all();
        $user_id = $dato['user_id'];
        $usersuh = Usersuh::select('id')->where('user_id', $user_id)->first();
        $id = $usersuh->id;
        $usersuh = Usersuh::find($id);
        $usersuh->delete();
        return Redirect::back();
    }

    public function getSites()
    {
        $sites_uh = Sitesuh::get();
        return View::make('ultimahora.sites')->with('sites_uh', $sites_uh);
    }

    public function postSites()
    {
        $site = [];
        $dato = Input::all();
        if (Request::ajax()) {
            $id = $dato['site_id'];
            $site = Sitesuh::where('id', $id)->first();
            return Response::json(['site_id' => $id, 'abrev' => $site->abrev, 'site' => $site->site]);
        } else {
            $rules = ['abrev' => 'required', 'site' => 'required'];
            $messages = ['abrev.required' => "abrev", 'site.required' => "site"];
            $validator = Validator::make($dato, $rules, $messages);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator->messages())->withInput();
            } else {
                $id = $dato['site_id'];
                $site = Sitesuh::where('id', $id)->first();
                if ($site == null) {
                    $dato = Input::all();
                    $site = new Sitesuh;
                    $site->abrev = $dato['abrev'];
                    $site->site = $dato['site'];
                    $site->save();
                    Session::flash('message', 'Se ha creado el sitio!');
                    return Redirect::back();
                } else {
                    $site = Sitesuh::find($id);
                    $site->abrev = $dato['abrev'];
                    $site->site = $dato['site'];
                    $site->save();
                    Session::flash('message', 'El sitio se ha actualizado!');
                    return Redirect::back();
                }
            }
        }
    }

    public function postSiteDelete()
    {
        $dato = Input::all();
        $site_id = $dato['site_id'];
        $site = Sitesuh::find($site_id);
        $site->delete();
        return Redirect::back();
    }
}
