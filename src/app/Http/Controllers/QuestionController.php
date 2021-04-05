<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request)
    {
        $survey = Survey::where('id', request()->surveyId)->first();

        return view('survey.question.create',compact('survey'));
    }
    public function store(Request $request)
    {
        $survey = Survey::where('id', request()->surveyId)->first();
        $this->validate($request,[
                'question'=>'required',
                'questionType'=>'required',
                'likertScaleAnswer'=>'required_if:questionType,range',
                'textChoice'=>'required_if:questionType,text',
                'choiceOne'=>'required_if:questionType,radio',
                'choiceTwo'=>'required_if:questionType,radio'
        ]);
        $type= $request->questionType;
        $singleAnswer = $request->likertScaleAnswer;
        $question = $survey->questions()->create([
            'question' => $request->question,
            'type' => $request->questionType
        ]);
        if($type === 'radio')
        {
            $question->answers()->createMany([['answerValue' => $request->choiceOne], ['answerValue' => $request->choiceTwo]]);
        }
        if($type === 'range')
        {
            $answerValue = $request->likertScaleAnswer;
            $question->answers()->create(['answerValue' => $answerValue]);
        }
        if($type === 'text')
        {
            $question->answers()->create(['answerValue' => $request->textChoice]);
        }
        return redirect('surveys/'.$request->surveyId); //redirect back to the survey
    }

    public function delete(Survey $survey, Questions $question)
    {
        $question->answers()->delete();
        $question->delete();
        return redirect('surveys/'.$survey->id)->with('alert', 'Question Deleted!');
    }

    public function show(Survey $survey)
    {
        $survey->load('questions');//lazy loading
        return view('survey.show',compact('survey'));
    }
}
