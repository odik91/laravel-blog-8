<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function index()
    {
        $title = 'Message';
        $messages = Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('admin.message.index', compact('title', 'messages'));
    }

    public function read($id)
    {
        $message = Message::where('id', $id)->limit(50)->first();
        $update = Message::find($id);
        $title = 'Read Message';
        $getIds = Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->get();
        $ids = [];

        foreach ($getIds as $id) {
            array_push($ids, $id['id']);
        }

        $data['read'] = 'read';
        $data['status'] = 'unanswered';

        $update->update($data);

        return view('admin.message.read', compact('message', 'title', 'ids'));
    }

    public function delete($id)
    {
        $message = Message::find($id);
        $name = $message['name'];
        $message->delete();
        return redirect()->route('message.index')->with('message', "Message from $name has been deleted");
    }

    // trash
    public function trash()
    {
        $messages = Message::onlyTrashed()->orderBy('deleted_at', 'desc')->limit(50)->get();
        $title = 'Message trash';
        return view('admin.message.trash', compact('messages', 'title'));
    }

    public function nextTrashPage(Request $request)
    {
        $input = $request->all();
        // return $input;
        if (ceil($input['offset'] / 50) <= ceil(count(Message::onlyTrashed()->get()) / 50)) {
            $results = Message::onlyTrashed()->orderBy('deleted_at', 'desc')->offset($input['offset'])->limit(50)->get();
            $output = [];

            foreach ($results as $result) {
                $subject = '';
                (strlen($result['subject']) > 62) ? $subject = ucfirst(strip_tags(substr($result['subject'], 0, 62))) . "..." : $subject = ucfirst($result['subject']);

                $time = '';
                $sendTime = strtotime($result['created_at']);
                $date = time();
                $diff = ($date - $sendTime) / 60;

                if ($diff < 60) {
                    $time = round($diff) . " min ago";
                } elseif ($diff < (60 * 60)) {
                    if (floor($diff / 60) > 24) {
                        $time = floor($diff / 60 / 24) . " days ago";
                    } else {
                        $time = floor($diff / 60) . " hours ago";
                    }
                } else {
                    $time = date_format(date_create(substr($result['created_at'], 0, (strlen($result['created_at']) - 9))), "D, d M Y");
                }

                array_push($output, [
                    'id' => $result['id'],
                    'name' => ucwords($result['name']),
                    'email' => $result['email'],
                    'to' => $result['to'],
                    'subject' => $subject,
                    'message' => $result['message'],
                    'read' => $result['read'],
                    'status' => $result['status'],
                    'drafts' => $result['drafts'],
                    'star' => $result['star'],
                    'time' => $time,
                ]);
            }
            return response()->json($output);
        }
    }

    // next previous message trash
    public function nextPage(Request $request)
    {
        $input = $request->all();

        if (ceil($input['offset'] / 50) < ceil(count(Message::onlyTrashed()->get()) / 50)) {
            $data = Message::onlyTrashed()->orderBy('id', 'desc')->offset($input['offset'])->limit(50)->get();
            $output = [];


            foreach ($data as $item) {
                $subject = '';
                if (strlen($item['subject']) > 62) {
                    $subject = ucfirst(strip_tags(substr($item['subject'], 0, 62))) . "...";
                } else {
                    $subject = ucfirst($item['subject']);
                }

                $time = '';
                $sendTime = strtotime($item['created_at']);
                $date = time();
                $diff = ($date - $sendTime) / 60;

                if ($diff < 60) {
                    $time = round($diff) . " min ago";
                } elseif ($diff < (60 * 60)) {
                    if (floor($diff / 60) > 24) {
                        $time = floor($diff / 60 / 24) . " days ago";
                    } else {
                        $time = floor($diff / 60) . " hours ago";
                    }
                } else {
                    $time = date_format(date_create(substr($item['created_at'], 0, (strlen($item['created_at']) - 9))), "D, d M Y");
                }

                array_push($output, [
                    'id' => $item['id'],
                    'name' => ucwords($item['name']),
                    'email' => $item['email'],
                    'to' => $item['to'],
                    'subject' => $subject,
                    'message' => $item['message'],
                    'read' => $item['read'],
                    'status' => $item['status'],
                    'drafts' => $item['drafts'],
                    'star' => $item['star'],
                    'time' => $time,
                ]);
            }

            return response()->json($output);
        }
    }

    // restoring message from trash
    public function restoreMessage(Request $request)
    {
        $data = $request->all();
        $result = [];
        if ($data['name'] == 'restore') {
            Message::onlyTrashed()->whereIn('id', $data['selection'])->restore();
            $result = [
                'status' => 'success',
                'message' => 'Message restore succesfully',
            ];
        } else if ($data['name'] == 'delete') {
            Message::onlyTrashed()->whereIn('id', $data['selection'])->forceDelete();
            $result = [
                'status' => 'success',
                'message' => 'Message removed succesfully',
            ];
        }

        $result['count'] = count(Message::where('drafts', 'drafts')->get());
        $result['inbox'] = count(Message::where('read', 'unread')->where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->get());
        $result['drafts'] = count(Message::where('drafts', 'drafts')->get());
        $result['trash'] = count(Message::onlyTrashed()->get());
        return $result;
        // return response()->json($result);
    }

    // next preview inbox mail
    public function nextPageInbox(Request $request)
    {
        $input = $request->all();
        if (ceil($input['offset'] / 50) < ceil(count(Message::where('drafts', '!=', 'drafts')->get()) / 50)) {
            $results = Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->offset($input['offset'])->limit(50)->get();
            $output = [];

            foreach ($results as $result) {
                $subject = '';
                (strlen($result['subject']) > 62) ? $subject = ucfirst(strip_tags(substr($result['subject'], 0, 62))) . "..." : $subject = ucfirst($result['subject']);

                $time = '';
                $sendTime = strtotime($result['created_at']);
                $date = time();
                $diff = ($date - $sendTime) / 60;

                if ($diff < 60) {
                    $time = round($diff) . " min ago";
                } elseif ($diff < (60 * 60)) {
                    if (floor($diff / 60) > 24) {
                        $time = floor($diff / 60 / 24) . " days ago";
                    } else {
                        $time = floor($diff / 60) . " hours ago";
                    }
                } else {
                    $time = date_format(date_create(substr($result['created_at'], 0, (strlen($result['created_at']) - 9))), "D, d M Y");
                }

                array_push($output, [
                    'id' => $result['id'],
                    'name' => ucwords($result['name']),
                    'email' => $result['email'],
                    'to' => $result['to'],
                    'subject' => $subject,
                    'message' => $result['message'],
                    'read' => $result['read'],
                    'status' => $result['status'],
                    'drafts' => $result['drafts'],
                    'star' => $result['star'],
                    'time' => $time,
                ]);
            }
            return response()->json($output);
        }
    }

    // delete message with ajax
    public function deleteMessage(Request $request)
    {
        $count = 0;
        if ($request['name'] == 'delete') {
            Message::whereIn('id', $request['selection'])->delete();

            $result = [
                'status' => 'success',
                'message' => 'Message deleted succesfully',
            ];
        } elseif ($request['name'] == 'destroy') {
            Message::onlyTrashed()->whereIn('id', $request['selection'])->forceDelete();
            $result = [
                'status' => 'success',
                'message' => 'Message destroy succesfully',
            ];
        }

        $reqForm = $request['from'];
        switch ($reqForm) {
            case "sent":
                $count = count(Message::where('status', 'sent')->orderBy('id', 'desc')->get());
                break;
            case 'drafts':
                $count = count(Message::where('drafts', 'drafts')->get());
                break;
            case 'destroy':
                $count = count(Message::onlyTrashed()->get());
                break;
            default;
                $count = Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->get();
        }

        $result['count'] = $count;
        $result['inbox'] = count(Message::where('read', 'unread')->where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->get());
        $result['drafts'] = count(Message::where('drafts', 'drafts')->get());
        $result['trash'] = count(Message::onlyTrashed()->get());

        return response()->json($result);
    }

    public function replyMessage(Request $request)
    {
        if (!$request) {
            return redirect()->route('message.index');
        }
        $receivers = Message::whereIn('id', $request['idReply'])->get();
        $title = 'Reply Message';
        return view('admin.message.multyReply', compact('receivers', 'title'));
    }

    public function sendingMulty(Request $request)
    {
        $this->validate($request, [
            'receivers' => 'required',
            'subject' => 'required|min:3',
            'message' => 'required|min:2'
        ]);

        $details = [
            'subject' => $request['subject'],
            'message' => $request['message']
        ];

        // dd($request['receivers']);

        for ($i = 0; $i < sizeof($request['receivers']); $i++) {
            Mail::to($request['receivers'][$i])->send(new SendMail($details));
        }

        $to = '';
        for ($i = 0; $i < sizeof($request['receivers']); $i++) {
            if ($i == sizeof($request['receivers']) - 1) {
                $to = $to . $request['receivers'][$i];
            } else {
                $to = $to . $request['receivers'][$i] . ', ';
            }
        }

        $data['name'] = ucwords(auth()->user()->name) . ' from benjol-blog';
        $data['email'] = 'admin@benjol-blog.com';
        $data['to'] = $to;
        $data['subject'] = $request['subject'];
        $data['message'] = $request['message'];
        $data['read'] = 'read';
        $data['status'] = 'sent ';
        $data['drafts'] = 'not a drafts';

        $id = Message::where('to', $to)->where('drafts', 'drafts')->first();
        if ($id) {
            $message = Message::find($id['id']);
            $message->update($data);
        } else {
            Message::create($data);
        }

        return redirect()->route('message.index')->with('message', 'Message has been sent');
    }

    public function compose()
    {
        $title = "Compose message";
        return view('admin.message.compose', compact('title'));
    }

    public function send(Request $request)
    {
        dd($request->all());
    }

    public function toDrafts(Request $request)
    {
        $to = '';
        if (sizeof($request['receivers']) > 0) {
            for ($i = 0; $i < sizeof($request['receivers']); $i++) {
                if ($i == sizeof($request['receivers']) - 1) {
                    $to = $to . $request['receivers'][$i];
                } else {
                    $to = $to . $request['receivers'][$i] . ', ';
                }
            }
        }

        $data['name'] = 'Admin';
        $data['email'] = 'admin@benjol-blog.com';
        $data['to'] = $to;
        $data['subject'] = $request['subject'];
        $data['message'] = $request['message'];
        $data['read'] = 'read';
        $data['status'] = 'pending ';
        $data['drafts'] = 'drafts ';

        $response = [];

        if ($request['id'] == 0) {
            Message::create($data);
            $id = Message::orderBy('id', 'DESC')->first();

            $response = array(
                'status' => 'success',
                'message' => 'Message has been saved to drafts',
                'id' => $id['id'],
                'inbox' => count(Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->get()),
                'drafts' => count(Message::where('drafts', 'drafts')->get())
            );
        } else {
            $message = Message::find($request['id']);
            $message->update($data);
            $response = array(
                'status' => 'success',
                'message' => 'Message has been saved to drafts',
                'id' => (int)$request['id'],
                'inbox' => count(Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->get()),
                'drafts' => count(Message::where('drafts', 'drafts')->get())
            );
        }

        return response()->json($response);
    }

    public function forward($id)
    {
        $content = Message::where('id', $id)->first();
        $title = 'Forward Message';

        return view('admin.message.forward', compact('content', 'title'));
    }

    public function star($id)
    {
        $star = Message::where('id', $id)->first();

        $data['star'] = '';
        if ($star['star'] == 'not starred') {
            $data['star'] = 'star';
        } else {
            $data['star'] = 'not starred';
        }

        $addStar = Message::find($id);
        $addStar->update($data);

        $output = [
            'status' => 'success',
            'message' => 'Star updated',
            'starred' => $data['star']
        ];
        return response()->json($output);
    }

    public function markRead(Request $request)
    {
        // update multiple data with input array
        $selection = $request['selection'];
        Message::whereIn('id', $request['selection'])->update(['read' => 'read']);
        $output = [
            'status' => 'success',
            'message' => sizeof($request['selection']) . " record has been updated"
        ];
        return response()->json($output);
    }

    public function checkInboxCount(Request $request)
    {
               
        if ($request['check'] == 'check inbox count') {
            $typeRequest = $request['name']; 
            switch ($typeRequest) {
                case 'sent':
                    $output = ['count' => count(Message::where('status', 'sent')->get())];
                    break;
                case 'drafts':
                    $output = ['count' => count(Message::where('drafts', 'drafts')->get())];
                    break;
                case 'trash':
                    $output = ['count' => count(Message::onlyTrashed()->get())];
                    break;
                default:
                    $output = ['count' => count(Message::where('drafts', '!=', 'drafts')->where('status', '!=', 'sent')->orderBy('created_at', 'desc')->get())];
            }
            return response()->json($output);
        }
    }

    public function sent()
    {
        $messages = Message::where('status', 'sent')->orderBy('id', 'desc')->limit(50)->get();
        $title = 'Sent messages';

        return view('admin.message.sent', compact('messages', 'title'));
    }

    public function nextSentPage(Request $request)
    {
        $input = $request->all();
        // return $input;
        if (ceil($input['offset'] / 50) <= ceil(count(Message::where('status', 'sent')->get()) / 50)) {
            $results = Message::where('status', 'sent')->orderBy('id', 'desc')->offset($input['offset'])->limit(50)->get();
            $output = [];

            foreach ($results as $result) {
                $subject = '';
                (strlen($result['subject']) > 62) ? $subject = ucfirst(strip_tags(substr($result['subject'], 0, 62))) . "..." : $subject = ucfirst($result['subject']);

                $time = '';
                $sendTime = strtotime($result['created_at']);
                $date = time();
                $diff = ($date - $sendTime) / 60;

                if ($diff < 60) {
                    $time = round($diff) . " min ago";
                } elseif ($diff < (60 * 60)) {
                    if (floor($diff / 60) > 24) {
                        $time = floor($diff / 60 / 24) . " days ago";
                    } else {
                        $time = floor($diff / 60) . " hours ago";
                    }
                } else {
                    $time = date_format(date_create(substr($result['created_at'], 0, (strlen($result['created_at']) - 9))), "D, d M Y");
                }

                array_push($output, [
                    'id' => $result['id'],
                    'name' => ucwords($result['name']),
                    'email' => $result['email'],
                    'to' => $result['to'],
                    'subject' => $subject,
                    'message' => $result['message'],
                    'read' => $result['read'],
                    'status' => $result['status'],
                    'drafts' => $result['drafts'],
                    'star' => $result['star'],
                    'time' => $time,
                ]);
            }
            return response()->json($output);
        }
    }

    public function editMessage($id)
    {
        $messages = Message::where('id', $id)->first();
        $title = 'Edit message';
        $receivers = explode(",", str_replace(' ', '', $messages['to']));

        return view('admin.message.editMessage', compact('messages', 'title', 'receivers'));
    }

    // drafts
    public function drafts()
    {
        $title = 'Drafts';
        $messages = Message::where('drafts', 'drafts')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('admin.message.drafts', compact('title', 'messages'));
    }

    public function nextDraftsPage(Request $request)
    {
        $input = $request->all();
        // return $input;
        if (ceil($input['offset'] / 50) <= ceil(count(Message::where('drafts', 'drafts')->get()) / 50)) {
            $results = Message::where('drafts', 'drafts')->orderBy('created_at', 'desc')->offset($input['offset'])->limit(50)->get();
            $output = [];

            foreach ($results as $result) {
                $subject = '';
                (strlen($result['subject']) > 62) ? $subject = ucfirst(strip_tags(substr($result['subject'], 0, 62))) . "..." : $subject = ucfirst($result['subject']);

                $time = '';
                $sendTime = strtotime($result['created_at']);
                $date = time();
                $diff = ($date - $sendTime) / 60;

                if ($diff < 60) {
                    $time = round($diff) . " min ago";
                } elseif ($diff < (60 * 60)) {
                    if (floor($diff / 60) > 24) {
                        $time = floor($diff / 60 / 24) . " days ago";
                    } else {
                        $time = floor($diff / 60) . " hours ago";
                    }
                } else {
                    $time = date_format(date_create(substr($result['created_at'], 0, (strlen($result['created_at']) - 9))), "D, d M Y");
                }

                array_push($output, [
                    'id' => $result['id'],
                    'name' => ucwords($result['name']),
                    'email' => $result['email'],
                    'to' => $result['to'],
                    'subject' => $subject,
                    'message' => $result['message'],
                    'read' => $result['read'],
                    'status' => $result['status'],
                    'drafts' => $result['drafts'],
                    'star' => $result['star'],
                    'time' => $time,
                ]);
            }
            return response()->json($output);
        }
    }
}
