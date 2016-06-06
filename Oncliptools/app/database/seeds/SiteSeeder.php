<?php
//clase para insertar sitio
class SiteSeeder extends Seeder {
 
    public function run()
    {
        $sites  =   array(
                        array(
                            "name"      => "vcms",
                            "domain"    =>  "oncliptools"
                        )
                    );

        $roles  =   array(
                        array(
                        'name'          => 'Admin',
                        'permissions'   => '{"users.create":1,"users.delete":1,"users.view":1,"users.update":1,"roles.create":1,"roles.view":1,"roles.update":1,"roles.delete":1}'
                        ),
                        array('name'    => 'Supervisor',
                        'permissions'   => '{"video.create":1,"video.view":1,"video.delete":1,"video.update":1}'
                        ),
                        array('name'    => 'Editor',
                        'permissions'   => '{"video.create":1,"video.view":1}'
                        )
                    );
        
        $count = Sites::all()->count();
        if($count==0){

            $groups_ids=array();        
            foreach ($roles as $role) {
                $group              = new Groups;
                $group->name        = $role["name"];
                $group->permissions = $role["permissions"];
                $group->save();
                $group_id = $group->id;
                array_push($groups_ids,$group_id);
            }
            
            
            foreach ($sites as $site) {
                $site_new = new Sites;
                $site_new->name=$site["name"];
                $site_new->domain=$site["domain"];
                $site_new->save();
                $site_id = $site_new->id_site;


                foreach ($groups_ids as $group_id) {
                    $groupsite  = new GroupSitesRelation;
                    $groupsite->id_site     =   $site_id;
                    $groupsite->id_group    =   $group_id;
                    $groupsite->save();
                }

            }
        }
        
        
    }
}