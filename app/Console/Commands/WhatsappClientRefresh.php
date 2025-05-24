<?php

namespace App\Console\Commands;

use App\Models\WhatsappClient;
use Illuminate\Console\Command;

class WhatsappClientRefresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $datas = WhatsappClient::fetchClientDetails();
        if ($datas['success']) {
            foreach ($datas['data'] as $data) {
                $client = WhatsappClient::where('client_id', $data['id'])->first();
                if (is_null($client)) {
                    WhatsappClient::deleteClient($data['id']);
                } else {
                    $client->name = $data['name'];
                    $client->status = $data['status'];
                    $client->save();
                }
            }
            // Extract all client IDs from $datas['data']
            $clientIds = array_column($datas['data'], 'id');

            // Update the status to "offline" for clients not in the current $datas['data'] list
            WhatsappClient::whereNotIn('client_id', $clientIds)->update([
                'status' => 'offline',
            ]);
        }
        return Command::SUCCESS;
    }
}
