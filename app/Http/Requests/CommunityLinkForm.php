<?php

namespace App\Http\Requests;

use App\CommunityLink;
use Illuminate\Foundation\Http\FormRequest;
use App\Exceptions\CommunityLinkAlreadySubmitted;

class CommunityLinkForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel_id' => 'required|exists:channels,id',
            'title' =>  'required',
            'url'   =>  'required|active_url',
        ];
    }

    /**
     * Persist the CommunityLink submission form.
     * @return [type] [description]
     */
    public function persist()
    {
        try {
            CommunityLink::from(auth()->user())->contribute($this->all());
            if (auth()->user()->isTrusted()) {
                flash('Thank for the contribution!', 'success');
            } else {
                flash()->overlay('Your contribution will be approved shortly', 'thanks');
            }
        } catch (CommunityLinkAlreadySubmitted $e) {
            flash()->overlay('we will instead bump the timestamps and bring that link back to the top',
                'That link has already been submitted');
        }
    }
}
