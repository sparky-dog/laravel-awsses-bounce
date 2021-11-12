<?php

namespace Fligno\SesBounce\Src\Console\Commands;

use Illuminate\Console\Command;

class SesBounceComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sesbounce:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will publish sesbounce component';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //import
        $components = 'import SesBounce from "../../../../../../SesBounce/src/resources/js/admin/pages/sesbounce"';
        $config = "Fligno/Auth/src/resources/js/admin/routes/index.js";
        $pointer = "//SesBounceImport";
        $this->writeSesbounce($components,$config,$pointer);
        //Route
        $components = '{path:"/sesbounce",exact:true,component:()=> <SesBounce/>},';
        $config = "Fligno/Auth/src/resources/js/admin/routes/index.js";
        $pointer = "//SesBounceRoute";
        $this->writeSesbounce($components,$config,$pointer);

        //Sidebar
        $components = '<MenuItem>
        <NavLink
              to="/sesbounce"
              activeClassName="font-bold text-white"
              className="flex items-center ml-3 py-1"
            ><span className="mr-2"><RiMailForbidLine/></span>Mail Bounce
            </NavLink>
        </MenuItem>';
        $config = "Fligno/Auth/src/resources/js/admin/components/Sidebar.js";
        $pointer = "//SesBounce";
        $this->writeSesbounce($components,$config,$pointer);


        $this->info("Sesbounce successfully rendered");
    }

    function writeSesbounce($components,$config,$pointer)
    {
        $file=fopen($config,"r+") or info("Unable to open file!");
        $newline="";
        $insertPos=0; 
          while (!feof($file)) {
            $line=fgets($file);
            if (strpos($line,$pointer)!==false) { 
                $insertPos=ftell($file);    
                $newline = $components."\r\n" ;
            } else {
                $newline.=$line;   
            }
        
        }
        fseek($file,$insertPos);   
        fwrite($file, $newline);
        fclose($file);
    }

}
