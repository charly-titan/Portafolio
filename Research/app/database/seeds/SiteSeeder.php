<?php
//clase para insertar sitio
class SiteSeeder extends Seeder {
 
    public function run()
    {
        if (App::environment('staging')) {
            $domain = 'esmas';
        }elseif (App::environment('aws')) {
            $domain = 'sinpk2';
        }else{
            $domain = 'televisa';
        }
        $sites  =   array(
                        array(
                            "name"      => "Sistema de Promociones",
                            "domain"    =>  $domain
                        )
                    );



        $roles  =   array(
                        array(
                        'name'          => 'Administrador',
                        'permissions'   => '{"users.create":1,"users.delete":1,"users.view":1,"users.update":1,"roles.create":1,"roles.view":1,"roles.update":1,"roles.delete":1,"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_date.update":1,"promo_tos.view":1,"promo_tos.update":1,"promo_owner.view":1,"promo_owner.update":1,"promo.view":1,"promo.create":1,"promo.update":1,"promo.list":1,"promo.delete":1,"info.download":1,"promo_css.view":1,"promo_css.update":1,"promo_social.view":1,"promo_social.update":1,"report.view":1,"report.create":1,"report.share":1,"promo_ventas.view":1,"promo_ventas.update":1,"promo_metricas.view":1,"promo_metricas.update":1,"twitter.update":1,"twitter.create":1,"twitter.refresh":1,"twitter.hide":1,"twitter.show":1}'
                        ),
                        array('name'    => 'Supervisor',
                        'permissions'   => '{"users.view":1,"roles.view":1,"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_date.update":1,"promo_tos.view":1,"promo_tos.update":1,"promo_owner.view":1,"promo_owner.update":1,"promo.view":1,"promo.create":1,"promo.update":1,"promo.list":1,"promo_css.view":1}'
                        ),
                        array('name'    => 'Dueño de la información',
                        'permissions'   => '{"info.download":1,"info.authorize":1,"users.view":1,"roles.view":1,"promo_info.view":1,"promo_date.view":1,"promo_tos.view":1,"promo.view":1,"promo.list":1}'
                        ),
                        array('name'    => 'Editor',
                        'permissions'   => '{"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_tos.view":1,"promo_owner.view":1,"promo.view":1,"promo.list":1}'
                        ),
                        array('name'    => 'Digital Manager',
                        'permissions'   => '{"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_date.update":1,"promo_tos.view":1,"promo_tos.update":1,"promo_owner.view":1,"promo.view":1,"promo.create":1,"promo.update":1,"promo.list":1}'
                        ),
                        array('name'    => 'Metricas Reporting',
                        'permissions'   => '{"promo.list":1,"report.view":1,"report.create":1,"report.share":1}'
                        ),
                        array('name'    => 'Metricas Configuration',
                        'permissions'   => '{"promo.list":1,"promo_metricas.view":1,"promo_metricas.update":1}'
                        ),
                        array('name'    => 'Ventas Configuration',
                        'permissions'   => '{"promo.list":1,"promo_ventas.view":1,"promo_ventas.update":1}'
                        ),
                        array('name'    => 'Front End',
                        'permissions'   => '{"promo.list":1,"promo_css.view":1,"promo_css.update":1,"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_tos.view":1,"promo_owner.view":1,"promo.view":1,"promo.list":1}'
                        ),
                        array('name'    => 'Social Media',
                        'permissions'   => '{"generateurl.view":1,"generateurl.create":1}'
                        ),
                        array('name'    => 'Pepsi Admin',
                        'permissions'   => '{"promo_info.view":1,"promo_info.update":1,"promo_date.view":1,"promo_date.update":1,"promo_tos.view":1,"promo_tos.update":1,"promo_owner.view":1,"promo.view":1,"promo.create":1,"promo.update":1,"promo.list":1,"photo_approve":1}'
                        )
                    );
        
        $groups_ids=array();        
        foreach ($roles as $role){
            $group = Groups::where('name',$role["name"])->first();
            if (is_null($group) or !count($group)){
                $groupNew              = new Groups;
                $groupNew->name        = $role["name"];
                $groupNew->permissions = $role["permissions"];
                $groupNew->save();
                $group_id = $groupNew->id;
                array_push($groups_ids,$group_id);
            }else{
                $group->permissions = $role["permissions"];
                $group->save();
                array_push($groups_ids,$group->id);
            }
            
            
        }

        foreach ($sites as $site) {
            $sit   =   Sites::where('name', $site["name"])
                             ->where('domain', $site["domain"])
                             ->first();
            if (is_null($sit) or !count($sit)){
                $site_new = new Sites;
                $site_new->name=$site["name"];
                $site_new->domain=$site["domain"];
                $site_new->save();
                $site_id = $site_new->id_site;
            }else
                $site_id = $sit->id_site;


            foreach ($groups_ids as $group_id) {
                $group_site = GroupSitesRelation::where('id_site', $site_id)
                                                ->where('id_group',$group_id)
                                                ->first();
                if (is_null($group_site) or !count($group_site)){
                    $groupsite  = new GroupSitesRelation;
                    $groupsite->id_site     =   $site_id;
                    $groupsite->id_group    =   $group_id;
                    $groupsite->save();
                }
            }

        }

        
    }
}