<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Approval;
use App\Models\CapaRequest;
use App\Models\Division;
use App\Models\Document;
use App\Models\InspectionRequest;
use App\Models\Project;
use App\Models\SubActivity;
use App\Models\SubDivision;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $seahaven = Project::create(['name' => 'Sobha Seahaven']);
        $crest = Project::create(['name' => 'The Crest']);
        $hartland = Project::create(['name' => 'Sobha Hartland II']);

        $finishing = Division::create(['name' => 'Finishing Division']);
        $mep = Division::create(['name' => 'MEP Division']);

        $sub = fn ($division, $name) => SubDivision::create(['division_id' => $division->id, 'name' => $name]);
        $plaster = $sub($finishing, 'Plaster Division');
        $masonry = $sub($finishing, 'Masonry Division');
        $ceiling = $sub($finishing, 'Ceiling Division');
        $tile = $sub($finishing, 'Tile Division');
        $electrical = $sub($mep, 'Electrical Division');

        $act = fn ($subDivision, $name) => Activity::create(['sub_division_id' => $subDivision->id, 'name' => $name]);
        $wallPlaster = $act($plaster, 'Wall Plastering');
        $aac = $act($masonry, 'AAC Block Work');
        $ceilingFinish = $act($ceiling, 'Ceiling Finish');
        $wallTiling = $act($tile, 'Wall Tiling');
        $dryFloor = $act($tile, 'Dry Area Floor');
        $sealant = $act($tile, 'Sealant Works');
        $giBox = $act($electrical, 'GI Box Fixing');

        // Inspection Configuration screen: name, activity, engineer, qcs, qaqc, random count
        $configs = [
            ['Wall/Corner-Rush Coat Applying', $wallPlaster, 0, 1, 1, 30],
            ['AAC Block Work Layout', $aac, 1, 1, 0, null],
            ['Ceiling Primer', $ceilingFinish, 1, 1, 0, null],
            ['Ceiling First coat', $ceilingFinish, 0, 1, 0, null],
            ['Wall Tile', $wallTiling, 0, 1, 0, null],
            ['Wall/Corner-Corner Bead Fixing', $wallPlaster, 0, 1, 1, 50],
            ['AAC Stage 3', $aac, 0, 1, 0, 20],
            ['Stip Fixing & Sealent Application', $sealant, 1, 1, 1, 10],
            ['Floor Tiling', $dryFloor, 0, 1, 1, null],
            ['GI Box Fixing', $giBox, 0, 1, 1, null],
        ];

        $subActivities = [];
        foreach ($configs as [$name, $activity, $e, $q, $a, $count]) {
            $subActivities[$name] = SubActivity::create([
                'project_id' => $seahaven->id,
                'activity_id' => $activity->id,
                'name' => $name,
                'level_engineer' => (bool) $e,
                'level_qcs' => (bool) $q,
                'level_qaqc' => (bool) $a,
                'random_inspection_count' => $count,
            ]);
        }

        // Inspection Request Detail screen
        $request = InspectionRequest::create([
            'project_id' => $hartland->id,
            'division_id' => $finishing->id,
            'sub_division_id' => $tile->id,
            'activity_id' => $dryFloor->id,
            'sub_activity_id' => $subActivities['Floor Tiling']->id,
            'tower' => 'Tower A',
            'floor' => 'A - P4',
            'unit' => 'A0402',
            'technician' => 'Akshay Jadhav',
            'status' => 'rejected',
            'requested_at' => '2023-12-01 11:45:00',
        ]);

        $approvals = [
            [1, 'Engineer - Approver', 'Ankita Bhat', 'approved', 'Request for Approval to @Vikas', '2023-12-01 11:45:00'],
            [2, 'QCS - Approver', 'Alok Sharma', 'approved', 'Request for Approval to @Vikas', '2023-12-01 11:45:00'],
            [3, 'QAQC - Approver', 'Vikas Gupta', 'rejected', 'Request Rejected and send for Approval to @Ankita', '2023-12-02 11:45:00'],
        ];
        foreach ($approvals as [$seq, $role, $name, $status, $comment, $at]) {
            Approval::create([
                'inspection_request_id' => $request->id,
                'sequence' => $seq,
                'role' => $role,
                'approver_name' => $name,
                'status' => $status,
                'comment' => $comment,
                'acted_at' => $at,
            ]);
        }

        foreach (['Document 1', 'Document 2'] as $doc) {
            Document::create([
                'inspection_request_id' => $request->id,
                'name' => $doc,
                'url' => '#',
            ]);
        }

        // CAPA Requests List screen
        $capas = [
            [$seahaven, 'Tower A', $finishing, $dryFloor, 'Floor Tiling', 'UCM Leak', 50, 'Engineer, QAQC', 'rejected', '2023-12-01 23:00:00'],
            [$seahaven, 'Tower A', $finishing, $dryFloor, 'Floor Tiling', 'Glass Bend', 80, 'Engineer, QAQC', 'open', '2023-12-01 23:00:00'],
            [$crest, 'Tower B', $finishing, $dryFloor, 'Floor Tiling', 'Wire not connected', 30, 'Engineer, QAQC', 'rejected', '2023-12-01 23:00:00'],
            [$hartland, 'Tower A', $mep, $giBox, 'GI Box Fixing', 'Screw missing', 60, 'QAQC', 'open', '2023-12-01 23:00:00'],
            [$seahaven, 'Tower C', $finishing, $dryFloor, 'Floor Tiling', 'FCD connection issue', 105, 'QAQC', 'closed', '2023-12-01 23:00:00'],
        ];
        foreach ($capas as [$project, $tower, $division, $activity, $subName, $defect, $count, $approver, $status, $at]) {
            CapaRequest::create([
                'project_id' => $project->id,
                'tower' => $tower,
                'division_id' => $division->id,
                'activity_id' => $activity->id,
                'sub_activity_id' => $subActivities[$subName]->id,
                'inspection_request_id' => $request->id,
                'defect_type' => $defect,
                'defect_count' => $count,
                'approver' => $approver,
                'status' => $status,
                'capa_created_at' => $at,
            ]);
        }
    }
}
