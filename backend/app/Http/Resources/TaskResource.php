<?php

namespace App\Http\Resources;

use App\Models\Document;
use App\Models\TaskAction;
use App\Models\User;
use App\Models\Task;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'completed' => $this->statusCount($this->id),
            'dueDate' => $this->due_to,
            'priority' => $this->type,
            'project_id' => $this->project_id,
            'created_by' => $this->created_by == auth()->id() ? true : false,
            'assign' => $this->userLoad($this->id),
            'documents' => $this->loadDocument($this->id),
            'comments'=> $this->loadComments($this->id),
        ];
    }

    private function userLoad($id)
    {
        $users = User::whereRelation('taskUser', 'task_id', $id)->get();

        return UserProjectResource::collection($users);
    }

    private function loadDocument($task_id)
    {
        $document = Document::where('task_id', $task_id)->get();

        return DocumentResource::collection($document);
    }
   private function statusCount($id)
{
    $taskAction = TaskAction::where('task_id', $id)->where('user_id',auth()->id())->count();
    if($taskAction ==0){
         $taskActionCount = TaskAction::where('task_id', $id)->count();
    $taskActionStatusCount = TaskAction::where('task_id', $id)
        ->where('status', 'completed')
        ->count();

    return $taskActionCount > 0 && $taskActionCount == $taskActionStatusCount;
    }else {
    $count=   TaskAction::where('task_id', $id)->where('user_id',auth()->id())
        ->where('status', 'completed')
        ->count();
        return $count  > 0 ? true : false;
    }

}
private function loadComments($task_id) {
    $comment =  Comment::where('commentable_type',Task::class)->where('commentable_id',$task_id)->get();
    return CommentResource::collection($comment);
}


}
