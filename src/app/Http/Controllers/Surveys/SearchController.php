<?php

namespace App\Http\Controllers\Surveys;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\User;
use App\models\Questions;
use App\models\AnswersRecorded;
use App\Models\SurveyList;
use App\models\SurveyUserList;
use Illuminate\Support\Facades\Auth;
class SearchController extends Controller
{

    public function index()
    {
        return view('searchUserPage');
    }

    public function search(Request $request)
    {
        // dd($request);
        //Search for correct participants' data and pass back to searchUserPage.
        $searchBar = $request->searchBar;
        $user = User::where('name','LIKE','%'.$searchBar.'%')->get();
        if(count($user) > 0)
            //$user and $searchBar will be send back as variable $details and $query
            return view('searchUserPage')->withDetails($user)->withQuery($searchBar);
        else
            return view ('searchUserPage')->withMessage('No such user found. Please try again !');
    }

    public function showProfileData(Request $request){
        //take data from database and pass to searchedUserProfilePage by using user id.
        // dd($request);
        $user_id = User::where('id', $request->id)->get();
        //find all survey that related to this user and completed, save to survey_datas_A.
        $survey_datas_A = SurveyUserList::where(['isCompleted' => true, 'user_id' => $request->id])->get();
        //find all survey that related to this user and not completed, save to survey_datas_B.
        $survey_datas_B = SurveyUserList::where(['isCompleted' => false, 'user_id' => $request->id])->get();
        $surveyA = SurveyList::where('id',$survey_datas_A[0]->id)->get();
        $surveyB = '';
        if(!$survey_datas_B->isEmpty())
        {
            $surveyB = SurveyList::where('id',$survey_datas_B[0]->id)->get();
        }
       // dd($surveyB);
        return view('dashboard/searchedUserProfilePage', compact('user_id', 'survey_datas_A', 'survey_datas_B','surveyA','surveyB'));
    }

    public function showAnswerData(Request $request){
        // dd($request->survey_id);
        //use user_id find user.
        $user = User::where('id', $request->id)->first();
        $questions_alt = Questions::where('survey_id', $request->survey_id)->get();
        // dd($questions_alt);
        $questions = [];
        foreach ($questions_alt as $questionz) {
            $questions[] = AnswersRecorded::where(
                [
                'participant_user_id' => $user->id,
                'question_id' => $questionz->id
                ]
            )->get();
        }

        return view('specificAnswerPage', compact('questions', 'questions_alt', 'user'));
    }
}
