<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignSource;
use App\Models\Intent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiktokController extends Controller
{
    public function scrape(Request $request)
    {
      // dd($request->all());
        // $curl = curl_init();

        // try {
        //     curl_setopt_array($curl, [
        //         CURLOPT_URL => "https://scraptik.p.rapidapi.com/list-comments?aweme_id=$request->tiktokId&count=1",
        //         CURLOPT_RETURNTRANSFER => true,
        //         CURLOPT_FOLLOWLOCATION => true,
        //         CURLOPT_ENCODING => "",
        //         CURLOPT_MAXREDIRS => 10,
        //         CURLOPT_TIMEOUT => 30,
        //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //         CURLOPT_CUSTOMREQUEST => "GET",
        //         CURLOPT_HTTPHEADER => [
        //             "X-RapidAPI-Host: scraptik.p.rapidapi.com",
        //             "X-RapidAPI-Key: ea0cbf0925mshe3eb8a4d6e2ad72p11ea6djsn4998a07eb575"
        //         ],
        //     ]);
    
        //     $response = curl_exec($curl);
        //     $err = curl_error($curl);
    
        //     curl_close($curl);
    
        //     if ($err) {
        //         echo "cURL Error #:" . $err;
        //     }
        // } catch (Exception $e) {
        //     echo $e;
        // }

        // if (!$response) {
        //     return response()->json([
        //         'status' => false,
        //     ]);
        // }

        DB::beginTransaction();
        $campaign = Campaign::create(['title' => $request->title]);

        foreach($request->url as $url) {
          // dd($url);
          $tiktokId = explode('/', $url['value'])[5];
          $campaignSource = CampaignSource::create(['url' => $tiktokId, 'campaign_id' => $campaign->id]);
        }
        // $comments = json_decode($response);
        // dd($comments);
        $data = '{
          "comments": [
            {
              "author_pin": false,
              "aweme_id": "6944028931875949829",
              "cid": "6951589702684344325",
              "create_time": 1618543108,
              "digg_count": 44,
              "is_author_digged": false,
              "label_list": null,
              "reply_comment": [
                {
                  "alias_aweme": {
                    "anchors": null,
                    "anchors_extras": "",
                    "author": {
                      "accept_private_policy": false,
                      "account_region": "",
                      "ad_cover_url": null,
                      "apple_account": 0,
                      "authority_status": 0,
                      "avatar_168x168": {
                        "height": 720,
                        "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_168x168.webp?x-expires=1619028000&x-signature=60lRwultH4Dz05gLLjvS7vXgPP4%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_168x168.jpeg?x-expires=1619028000&x-signature=vSD3gWQa3ah%2FkTGq9nJVePk3tr0%3D"
                        ],
                        "width": 720
                      },
                      "avatar_300x300": {
                        "height": 720,
                        "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_300x300.webp?x-expires=1619028000&x-signature=Qql3QQZ5mAljU9GnJrrXhmPDC7E%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_300x300.jpeg?x-expires=1619028000&x-signature=zrIDS8BfKHbhQfje7FEO716CdF0%3D"
                        ],
                        "width": 720
                      },
                      "avatar_larger": {
                        "height": 720,
                        "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_1080x1080.webp?x-expires=1619028000&x-signature=c0v1GbodJPwgw4zAvxZWSYB7Ypc%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_1080x1080.jpeg?x-expires=1619028000&x-signature=CYje1kModS4KaRAdSjewVLOv1L0%3D"
                        ],
                        "width": 720
                      },
                      "avatar_medium": {
                        "height": 720,
                        "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_720x720.webp?x-expires=1619028000&x-signature=2o642kL0qItHBcpax5RNhQbt1n8%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_720x720.jpeg?x-expires=1619028000&x-signature=QAV29irQeBRKfrY9%2F8b%2FHXwyB%2BE%3D"
                        ],
                        "width": 720
                      },
                      "avatar_thumb": {
                        "height": 720,
                        "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_100x100.webp?x-expires=1619028000&x-signature=vCzZpy0K3G0OddM%2B1WwAHJqFFsw%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_100x100.jpeg?x-expires=1619028000&x-signature=xkVEHem9QkYHbO3%2B0NAMEvwSilo%3D"
                        ],
                        "width": 720
                      },
                      "avatar_uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "aweme_count": 0,
                      "bind_phone": "",
                      "bold_fields": null,
                      "can_set_geofencing": null,
                      "cha_list": null,
                      "comment_filter_status": 0,
                      "comment_setting": 0,
                      "commerce_user_level": 0,
                      "cover_url": [
                        {
                          "height": 720,
                          "uri": "musically-maliva-obj/1612555907887110",
                          "url_list": [
                            "https://p16-amd-va.tiktokcdn.com/obj/musically-maliva-obj/1612555907887110"
                          ],
                          "width": 720
                        }
                      ],
                      "create_time": 0,
                      "custom_verify": "",
                      "cv_level": "",
                      "download_prompt_ts": 0,
                      "download_setting": 0,
                      "duet_setting": 0,
                      "enterprise_verify_reason": "",
                      "events": null,
                      "favoriting_count": 0,
                      "fb_expire_time": 0,
                      "follow_status": 0,
                      "follower_count": 0,
                      "follower_status": 0,
                      "followers_detail": null,
                      "following_count": 0,
                      "geofencing": null,
                      "google_account": "",
                      "has_email": false,
                      "has_facebook_token": false,
                      "has_insights": false,
                      "has_orders": false,
                      "has_twitter_token": false,
                      "has_youtube_token": false,
                      "hide_search": false,
                      "homepage_bottom_toast": null,
                      "ins_id": "rd_calligraphy",
                      "is_ad_fake": false,
                      "is_block": false,
                      "is_discipline_member": false,
                      "is_phone_binded": false,
                      "is_star": false,
                      "item_list": null,
                      "language": "en",
                      "live_agreement": 0,
                      "live_commerce": false,
                      "live_verify": 0,
                      "mutual_relation_avatars": null,
                      "need_points": null,
                      "need_recommend": 0,
                      "nickname": "Raquel",
                      "platform_sync_info": null,
                      "prevent_download": false,
                      "qa_status": 0,
                      "react_setting": 0,
                      "region": "US",
                      "relative_users": null,
                      "room_id": 0,
                      "search_highlight": null,
                      "sec_uid": "MS4wLjABAAAAjEeVQDYvGX8tfiNwum_aSMpbXa9-qFEh-F1pvs4IqiRUyXHPqgHeZqV4eAfQheEi",
                      "secret": 0,
                      "shield_comment_notice": 0,
                      "shield_digg_notice": 0,
                      "shield_follow_notice": 0,
                      "short_id": "0",
                      "show_image_bubble": false,
                      "signature": "www.rdcalligraphy.com\nProfessional calligrapher and engraver",
                      "special_lock": 1,
                      "status": 1,
                      "stitch_setting": 0,
                      "total_favorited": 0,
                      "tw_expire_time": 0,
                      "twitter_id": "",
                      "twitter_name": "",
                      "type_label": null,
                      "uid": "6867005556525237253",
                      "unique_id": "rd_calligraphy",
                      "unique_id_modify_time": 1618944859,
                      "user_canceled": false,
                      "user_mode": 1,
                      "user_period": 0,
                      "user_rate": 1,
                      "user_tags": null,
                      "verification_type": 0,
                      "verify_info": "",
                      "video_icon": {
                        "height": 720,
                        "uri": "",
                        "url_list": [],
                        "width": 720
                      },
                      "white_cover_url": null,
                      "with_commerce_entry": false,
                      "with_shop_entry": false,
                      "youtube_channel_id": "",
                      "youtube_channel_title": "",
                      "youtube_expire_time": 0
                    },
                    "author_user_id": 6867005556525237000,
                    "aweme_acl": {
                      "download_general": {
                        "code": 0,
                        "mute": false,
                        "show_type": 2,
                        "transcode": 3
                      },
                      "download_mask_panel": {
                        "code": 0,
                        "mute": false,
                        "show_type": 2,
                        "transcode": 3
                      },
                      "platform_list": null,
                      "share_general": {
                        "code": 0,
                        "mute": false,
                        "show_type": 2,
                        "transcode": 3
                      },
                      "share_list_status": 0
                    },
                    "aweme_id": "6951849648768175365",
                    "aweme_type": 0,
                    "bodydance_score": 0,
                    "cha_list": null,
                    "challenge_position": null,
                    "cmt_swt": false,
                    "collect_stat": 0,
                    "commerce_config_data": null,
                    "commerce_info": {
                      "adv_promotable": false,
                      "auction_ad_invited": false,
                      "with_comment_filter_words": false
                    },
                    "cover_labels": null,
                    "create_time": 1618603631,
                    "desc": "Reply to @shannindelgado #pointedpencalligraphy #asmr #flourishedcalligraphy #satisfyingvideo #oddlysatifyingvideos #foryoupage #fyp #smallbusiness",
                    "desc_language": "en",
                    "distance": "",
                    "distribute_type": 1,
                    "geofencing": null,
                    "geofencing_regions": null,
                    "group_id": "6951849648768175365",
                    "has_vs_entry": false,
                    "have_dashboard": false,
                    "hybrid_label": null,
                    "image_infos": null,
                    "interaction_stickers": null,
                    "is_hash_tag": 1,
                    "is_pgcshow": false,
                    "is_preview": 0,
                    "is_relieve": false,
                    "is_top": 0,
                    "is_vr": false,
                    "item_comment_settings": 0,
                    "item_duet": 0,
                    "item_react": 0,
                    "item_stitch": 0,
                    "label_top_text": null,
                    "long_video": null,
                    "mask_infos": [],
                    "misc_info": "{}",
                    "music": {
                      "album": "",
                      "artists": [],
                      "audition_duration": 168,
                      "author": "Makoto Hiramatsu",
                      "author_deleted": false,
                      "author_position": null,
                      "binded_challenge_id": 0,
                      "collect_stat": 0,
                      "cover_large": {
                        "height": 720,
                        "uri": "tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png",
                        "url_list": [
                          "https://p16-sg.tiktokcdn.com/aweme/720x720/tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png.jpeg"
                        ],
                        "width": 720
                      },
                      "cover_medium": {
                        "height": 720,
                        "uri": "tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png",
                        "url_list": [
                          "https://p16-sg.tiktokcdn.com/aweme/200x200/tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png.jpeg"
                        ],
                        "width": 720
                      },
                      "cover_thumb": {
                        "height": 720,
                        "uri": "tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png",
                        "url_list": [
                          "https://p16-sg.tiktokcdn.com/aweme/100x100/tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png.jpeg"
                        ],
                        "width": 720
                      },
                      "dmv_auto_show": false,
                      "duration": 168,
                      "external_song_info": [],
                      "extra": "{\"is_ugc_mapping\":false,\"has_edited\":0,\"reviewed\":0,\"review_unshelve_reason\":0,\"beats\":{},\"schedule_search_time\":0,\"aed_music_dur\":166.56}",
                      "id": 6925526464759368000,
                      "id_str": "6925526464759367681",
                      "is_audio_url_with_cookie": false,
                      "is_author_artist": false,
                      "is_commerce_music": true,
                      "is_matched_metadata": false,
                      "is_original": false,
                      "is_original_sound": false,
                      "is_pgc": true,
                      "lyric_short_position": null,
                      "matched_song": {
                        "author": "Makoto Hiramatsu",
                        "cover_medium": {
                          "height": 720,
                          "uri": "tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png",
                          "url_list": [
                            "https://p16-sg.tiktokcdn.com/aweme/200x200/tiktok-obj/6f9903752958820d144fa90d54cb5f3a.png.jpeg"
                          ],
                          "width": 720
                        },
                        "h5_url": "",
                        "id": "6925526464666273794",
                        "title": "Chopin, Waltz Op70 No.2(950517)"
                      },
                      "mid": "6925526464759367681",
                      "mute_share": false,
                      "offline_desc": "",
                      "owner_handle": "",
                      "owner_nickname": "",
                      "play_url": {
                        "height": 720,
                        "uri": "https://sf16-ies-music-sg.tiktokcdn.com/obj/tiktok-obj/b4c3992550073145576cd28128eaca34.mp3",
                        "url_list": [
                          "https://sf16-ies-music-sg.tiktokcdn.com/obj/tiktok-obj/b4c3992550073145576cd28128eaca34.mp3"
                        ],
                        "width": 720
                      },
                      "position": null,
                      "prevent_download": false,
                      "preview_end_time": 0,
                      "preview_start_time": 0,
                      "search_highlight": null,
                      "shoot_duration": 168,
                      "source_platform": 10036,
                      "status": 1,
                      "tag_list": null,
                      "title": "Chopin, Waltz Op70 No.2(950517)",
                      "unshelve_countries": null,
                      "user_count": 0,
                      "video_duration": 180
                    },
                    "need_vs_entry": false,
                    "nickname_position": null,
                    "origin_comment_ids": null,
                    "position": null,
                    "prevent_download": false,
                    "rate": 12,
                    "region": "US",
                    "risk_infos": {
                      "content": "",
                      "risk_sink": false,
                      "type": 0,
                      "vote": false,
                      "warn": false
                    },
                    "search_highlight": null,
                    "sort_label": "",
                    "statistics": {
                      "aweme_id": "6951849648768175365",
                      "comment_count": 0,
                      "digg_count": 504,
                      "download_count": 2,
                      "forward_count": 0,
                      "lose_comment_count": 0,
                      "lose_count": 0,
                      "play_count": 4363,
                      "share_count": 22,
                      "whatsapp_share_count": 0
                    },
                    "status": {
                      "allow_comment": true,
                      "allow_share": true,
                      "aweme_id": "6951849648768175365",
                      "download_status": 0,
                      "in_reviewing": false,
                      "is_delete": false,
                      "is_prohibited": false,
                      "private_status": 0,
                      "review_result": {
                        "review_status": 0
                      },
                      "reviewed": 1,
                      "self_see": false
                    },
                    "text_extra": [
                      {
                        "end": 24,
                        "sec_uid": "MS4wLjABAAAAnb0HqFEnQ4EwP1V8W17PjVAamK5BOQGUiLzrFbgVR2Ry9Vb4v2AR9blveSLbQYEN",
                        "start": 9,
                        "sub_type": 2,
                        "type": 0,
                        "user_id": "6766766078486184966"
                      },
                      {
                        "end": 47,
                        "hashtag_name": "pointedpencalligraphy",
                        "start": 25,
                        "type": 1
                      },
                      {
                        "end": 53,
                        "hashtag_name": "asmr",
                        "start": 48,
                        "type": 1
                      },
                      {
                        "end": 76,
                        "hashtag_name": "flourishedcalligraphy",
                        "start": 54,
                        "type": 1
                      },
                      {
                        "end": 93,
                        "hashtag_name": "satisfyingvideo",
                        "start": 77,
                        "type": 1
                      },
                      {
                        "end": 115,
                        "hashtag_name": "oddlysatifyingvideos",
                        "start": 94,
                        "type": 1
                      },
                      {
                        "end": 127,
                        "hashtag_name": "foryoupage",
                        "start": 116,
                        "type": 1
                      },
                      {
                        "end": 132,
                        "hashtag_name": "fyp",
                        "start": 128,
                        "type": 1
                      },
                      {
                        "end": 147,
                        "hashtag_name": "smallbusiness",
                        "start": 133,
                        "type": 1
                      }
                    ],
                    "uniqid_position": null,
                    "user_digged": 0,
                    "video": {
                      "ai_dynamic_cover": {
                        "uri": "tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634~tplv-dmt-logom:tos-maliva-p-0000/54cff4d6256d4cbf93e1e7cbe7712fae.image?x-expires=1618963200&x-signature=XslGsg%2FJFKc1ZRhSnQdMABfGNaw%3D"
                        ]
                      },
                      "ai_dynamic_cover_bak": {
                        "uri": "tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634~tplv-dmt-logom:tos-maliva-p-0000/54cff4d6256d4cbf93e1e7cbe7712fae.image?x-expires=1618963200&x-signature=XslGsg%2FJFKc1ZRhSnQdMABfGNaw%3D"
                        ]
                      },
                      "animated_cover": {
                        "uri": "tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/99b892f1cf8f411188d09bf92e21a65e_1618603634~tplv-dmt-logom:tos-maliva-p-0000/54cff4d6256d4cbf93e1e7cbe7712fae.image?x-expires=1618963200&x-signature=XslGsg%2FJFKc1ZRhSnQdMABfGNaw%3D"
                        ]
                      },
                      "big_thumbs": null,
                      "bit_rate": [
                        {
                          "bit_rate": 275315,
                          "gear_name": "adapt_lower_720",
                          "is_bytevc1": 1,
                          "play_addr": {
                            "data_size": 1547034,
                            "file_cs": "c:0-38399-beb3",
                            "file_hash": "a2e41b2971cec5f8a49c23abfe50c814",
                            "height": 720,
                            "uri": "v09044g40000c1susoop8rsfrlroubhg",
                            "url_key": "v09044g40000c1susoop8rsfrlroubhg_bytevc1_720p_275315",
                            "url_list": [
                              "https://v39-us.tiktokcdn.com/dcda4e69080f2fdfba040a00e364fc74/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/9bb440107efb4be486645662c7ba48e3/?a=1233&br=536&bt=268&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=3&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=14&rc=amVyb2l1c3J4NDMzNzczM0ApODk1Nzs7MzxlN2dpNzUzZWdlcm9vcDVscHBgLS1kMTZzc2MvMC5gMjAzYF8wXjZgMjA6Yw%3D%3D&vl=&vr=",
                              "https://v25-us.tiktokcdn.com/a4d90315c0e9ae230bb4c4464b4fc9d6/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/9bb440107efb4be486645662c7ba48e3/?a=1233&br=536&bt=268&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=3&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=14&rc=amVyb2l1c3J4NDMzNzczM0ApODk1Nzs7MzxlN2dpNzUzZWdlcm9vcDVscHBgLS1kMTZzc2MvMC5gMjAzYF8wXjZgMjA6Yw%3D%3D&vl=&vr=",
                              "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=720p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&bytevc1=1&quality_type=13&source=PackSourceEnum_COMMENT_LIST"
                            ],
                            "width": 720
                          },
                          "quality_type": 14
                        },
                        {
                          "bit_rate": 208964,
                          "gear_name": "adapt_540",
                          "is_bytevc1": 1,
                          "play_addr": {
                            "data_size": 1174199,
                            "file_cs": "c:0-38399-8a01",
                            "file_hash": "3d22d3014394306d7059ac726c95db18",
                            "height": 720,
                            "uri": "v09044g40000c1susoop8rsfrlroubhg",
                            "url_key": "v09044g40000c1susoop8rsfrlroubhg_bytevc1_540p_208964",
                            "url_list": [
                              "https://v39-us.tiktokcdn.com/72fb91fafcd192b4849cfdaa0c542492/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c004/27e85790216e4f9ab9b26ca8b1173c6c/?a=1233&br=408&bt=204&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=11&rc=amVyb2l1c3J4NDMzNzczM0ApNTc5ZmU3aWRoNzUzMzMzNWdlcm9vcDVscHBgLS1kMTZzc2AvXzNiYzBhMV8xLV9iYS06Yw%3D%3D&vl=&vr=",
                              "https://v25-us.tiktokcdn.com/184f919399d9b3c1e5708d1c15490f3c/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c004/27e85790216e4f9ab9b26ca8b1173c6c/?a=1233&br=408&bt=204&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=11&rc=amVyb2l1c3J4NDMzNzczM0ApNTc5ZmU3aWRoNzUzMzMzNWdlcm9vcDVscHBgLS1kMTZzc2AvXzNiYzBhMV8xLV9iYS06Yw%3D%3D&vl=&vr=",
                              "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&bytevc1=1&quality_type=11&adapt540=1&source=PackSourceEnum_COMMENT_LIST"
                            ],
                            "width": 720
                          },
                          "quality_type": 28
                        },
                        {
                          "bit_rate": 123281,
                          "gear_name": "lower_540",
                          "is_bytevc1": 1,
                          "play_addr": {
                            "data_size": 692736,
                            "file_cs": "c:0-38399-1762",
                            "file_hash": "502e25d27fb10e4d8e82a65eb3f25c66",
                            "height": 720,
                            "uri": "v09044g40000c1susoop8rsfrlroubhg",
                            "url_key": "v09044g40000c1susoop8rsfrlroubhg_bytevc1_540p_123281",
                            "url_list": [
                              "https://v39-us.tiktokcdn.com/070ae9ad4822e38b76187d033c3f32a6/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/dba04cd6067a45c18249013c756fd6c4/?a=1233&br=240&bt=120&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=4&rc=amVyb2l1c3J4NDMzNzczM0ApPDpoNGc4NmQ5NzVmOGUzZmdlcm9vcDVscHBgLS1kMTZzczI2NTYwLS02NjY0NWMvMTY6Yw%3D%3D&vl=&vr=",
                              "https://v25-us.tiktokcdn.com/c42c3b7b6348364968718586378b4352/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/dba04cd6067a45c18249013c756fd6c4/?a=1233&br=240&bt=120&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=4&rc=amVyb2l1c3J4NDMzNzczM0ApPDpoNGc4NmQ5NzVmOGUzZmdlcm9vcDVscHBgLS1kMTZzczI2NTYwLS02NjY0NWMvMTY6Yw%3D%3D&vl=&vr=",
                              "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&bytevc1=1&quality_type=4&source=PackSourceEnum_COMMENT_LIST"
                            ],
                            "width": 720
                          },
                          "quality_type": 24
                        },
                        {
                          "bit_rate": 87131,
                          "gear_name": "lowest_540",
                          "is_bytevc1": 1,
                          "play_addr": {
                            "data_size": 489604,
                            "file_cs": "c:0-38399-d480",
                            "file_hash": "366c67e77d0cba09d3712bc644cd57cf",
                            "height": 720,
                            "uri": "v09044g40000c1susoop8rsfrlroubhg",
                            "url_key": "v09044g40000c1susoop8rsfrlroubhg_bytevc1_540p_87131",
                            "url_list": [
                              "https://v39-us.tiktokcdn.com/36c2c0ba80327f30ac294cfae5afa3be/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c001/0ed6b6fe992d4447a7fd94bef640d697/?a=1233&br=170&bt=85&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=5&rc=amVyb2l1c3J4NDMzNzczM0ApNTg3ODY6Zjw6NzhmPDxoOmdlcm9vcDVscHBgLS1kMTZzc2ExX2FiX2MzNV5iLTE0NWA6Yw%3D%3D&vl=&vr=",
                              "https://v25-us.tiktokcdn.com/04ce0281f2e935cc7ea7d3ccb94ee298/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c001/0ed6b6fe992d4447a7fd94bef640d697/?a=1233&br=170&bt=85&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=5&rc=amVyb2l1c3J4NDMzNzczM0ApNTg3ODY6Zjw6NzhmPDxoOmdlcm9vcDVscHBgLS1kMTZzc2ExX2FiX2MzNV5iLTE0NWA6Yw%3D%3D&vl=&vr=",
                              "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&bytevc1=1&quality_type=5&source=PackSourceEnum_COMMENT_LIST"
                            ],
                            "width": 720
                          },
                          "quality_type": 25
                        }
                      ],
                      "cdn_url_expired": 0,
                      "cover": {
                        "height": 720,
                        "uri": "tos-maliva-p-0068/423980a589694990b3fbfddca34f509e_1618603637",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/423980a589694990b3fbfddca34f509e_1618603637~tplv-dmt-logoccm:300:400:tos-maliva-p-0000/54cff4d6256d4cbf93e1e7cbe7712fae.jpeg?x-expires=1618963200&x-signature=cWRWBttuiyIQPhQ9MUVOqqsIfag%3D"
                        ],
                        "width": 720
                      },
                      "download_addr": {
                        "data_size": 2225760,
                        "height": 720,
                        "uri": "v09044g40000c1susoop8rsfrlroubhg",
                        "url_list": [
                          "https://v39-us.tiktokcdn.com/08f72474a4a8e917909872c0c22a4d15/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c002/b6dffefa24db46adb8650345b1865d33/?a=1233&br=772&bt=386&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=3&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApZzc6O2U6Ojw5Nzo4OTw8ZGdlcm9vcDVscHBgLS1kMTZzc2EzYC00Yl9eM2JeMF9eNC86Yw%3D%3D&vl=&vr=",
                          "https://v25-us.tiktokcdn.com/71da684fc16e9b9a4f662fee538f18a4/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c002/b6dffefa24db46adb8650345b1865d33/?a=1233&br=772&bt=386&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=3&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApZzc6O2U6Ojw5Nzo4OTw8ZGdlcm9vcDVscHBgLS1kMTZzc2EzYC00Yl9eM2JeMF9eNC86Yw%3D%3D&vl=&vr=",
                          "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&watermark=1&media_type=4&vr_type=0&improve_bitrate=0&logo_name=tiktok_m&quality_type=11&source=COMMENT_LIST"
                        ],
                        "width": 720
                      },
                      "duration": 44953,
                      "dynamic_cover": {
                        "height": 720,
                        "uri": "tos-maliva-p-0068/a214b798f3384c0c83cfccc934803741_1618603633",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/a214b798f3384c0c83cfccc934803741_1618603633~tplv-dmt-logom:tos-maliva-p-0000/54cff4d6256d4cbf93e1e7cbe7712fae.image?x-expires=1618963200&x-signature=%2Fedk82z5kqD2aH9l6Atdxq%2B2Q9k%3D"
                        ],
                        "width": 720
                      },
                      "has_watermark": true,
                      "height": 1024,
                      "is_bytevc1": 0,
                      "is_callback": true,
                      "meta": "{\"loudness\":\"-21\",\"peak\":\"0.41687\"}",
                      "need_set_token": false,
                      "origin_cover": {
                        "height": 720,
                        "uri": "tos-maliva-p-0068/88d77a9e0f444344a40793c63a528f12_1618603633",
                        "url_list": [
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/88d77a9e0f444344a40793c63a528f12_1618603633~tplv-tiktokx-360p.webp?x-expires=1618963200&x-signature=cG1scbRZSvAL%2BSdx622SqUspxzI%3D",
                          "https://p16-sign-va.tiktokcdn.com/tos-maliva-p-0068/88d77a9e0f444344a40793c63a528f12_1618603633~tplv-tiktokx-360p.jpeg?x-expires=1618963200&x-signature=LZ3r2buOP0Q8MDomjLkwexbXOQA%3D"
                        ],
                        "width": 720
                      },
                      "play_addr": {
                        "data_size": 2141381,
                        "file_cs": "c:0-38129-ed77",
                        "file_hash": "b5248df0646c5c49e764b94d123df606",
                        "height": 720,
                        "uri": "v09044g40000c1susoop8rsfrlroubhg",
                        "url_key": "v09044g40000c1susoop8rsfrlroubhg_h264_540p_381087",
                        "url_list": [
                          "https://v39-us.tiktokcdn.com/1c6fd3620d15e4b2a04931eebd1d6bfa/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/3555960eddd042f59e5ec48d0fd86171/?a=1233&br=744&bt=372&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApaGc2NDo8OztlN2RoOjs7NWdlcm9vcDVscHBgLS1kMTZzczVhNDM2XjNeLl8yM140Ml46Yw%3D%3D&vl=&vr=",
                          "https://v25-us.tiktokcdn.com/8ead94048e9180a45df40ca785667a01/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/3555960eddd042f59e5ec48d0fd86171/?a=1233&br=744&bt=372&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApaGc2NDo8OztlN2RoOjs7NWdlcm9vcDVscHBgLS1kMTZzczVhNDM2XjNeLl8yM140Ml46Yw%3D%3D&vl=&vr=",
                          "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&source=PackSourceEnum_COMMENT_LIST"
                        ],
                        "width": 720
                      },
                      "play_addr_bytevc1": {
                        "data_size": 1174199,
                        "file_cs": "c:0-38399-8a01",
                        "file_hash": "3d22d3014394306d7059ac726c95db18",
                        "height": 720,
                        "uri": "v09044g40000c1susoop8rsfrlroubhg",
                        "url_key": "v09044g40000c1susoop8rsfrlroubhg_bytevc1_540p_208964",
                        "url_list": [
                          "https://v39-us.tiktokcdn.com/72fb91fafcd192b4849cfdaa0c542492/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c004/27e85790216e4f9ab9b26ca8b1173c6c/?a=1233&br=408&bt=204&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=11&rc=amVyb2l1c3J4NDMzNzczM0ApNTc5ZmU3aWRoNzUzMzMzNWdlcm9vcDVscHBgLS1kMTZzc2AvXzNiYzBhMV8xLV9iYS06Yw%3D%3D&vl=&vr=",
                          "https://v25-us.tiktokcdn.com/184f919399d9b3c1e5708d1c15490f3c/607f77e7/video/tos/useast2a/tos-useast2a-ve-0068c004/27e85790216e4f9ab9b26ca8b1173c6c/?a=1233&br=408&bt=204&cd=0%7C0%7C0&ch=0&cr=3&cs=&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=11&rc=amVyb2l1c3J4NDMzNzczM0ApNTc5ZmU3aWRoNzUzMzMzNWdlcm9vcDVscHBgLS1kMTZzc2AvXzNiYzBhMV8xLV9iYS06Yw%3D%3D&vl=&vr=",
                          "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&bytevc1=1&quality_type=11&adapt540=1&source=PackSourceEnum_COMMENT_LIST"
                        ],
                        "width": 720
                      },
                      "play_addr_h264": {
                        "data_size": 2141381,
                        "file_cs": "c:0-38129-ed77",
                        "file_hash": "b5248df0646c5c49e764b94d123df606",
                        "height": 720,
                        "uri": "v09044g40000c1susoop8rsfrlroubhg",
                        "url_key": "v09044g40000c1susoop8rsfrlroubhg_h264_540p_381087",
                        "url_list": [
                          "https://v39-us.tiktokcdn.com/1c6fd3620d15e4b2a04931eebd1d6bfa/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/3555960eddd042f59e5ec48d0fd86171/?a=1233&br=744&bt=372&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApaGc2NDo8OztlN2RoOjs7NWdlcm9vcDVscHBgLS1kMTZzczVhNDM2XjNeLl8yM140Ml46Yw%3D%3D&vl=&vr=",
                          "https://v25-us.tiktokcdn.com/8ead94048e9180a45df40ca785667a01/607f77e7/video/tos/useast2a/tos-useast2a-pve-0068/3555960eddd042f59e5ec48d0fd86171/?a=1233&br=744&bt=372&cd=0%7C0%7C0&ch=0&cr=3&cs=0&cv=1&dr=0&ds=6&er=&l=20210420185419010189073069504807DB&lr=all&mime_type=video_mp4&net=0&pl=0&qs=0&rc=amVyb2l1c3J4NDMzNzczM0ApaGc2NDo8OztlN2RoOjs7NWdlcm9vcDVscHBgLS1kMTZzczVhNDM2XjNeLl8yM140Ml46Yw%3D%3D&vl=&vr=",
                          "https://api16-normal-c-useast1a.tiktokv.com/aweme/v1/play/?video_id=v09044g40000c1susoop8rsfrlroubhg&line=0&ratio=540p&media_type=4&vr_type=0&improve_bitrate=0&is_play_url=1&source=PackSourceEnum_COMMENT_LIST"
                        ],
                        "width": 720
                      },
                      "ratio": "540p",
                      "tags": null,
                      "width": 576
                    },
                    "video_control": {
                      "allow_download": false,
                      "allow_duet": true,
                      "allow_dynamic_wallpaper": true,
                      "allow_music": true,
                      "allow_react": true,
                      "allow_stitch": true,
                      "draft_progress_bar": 1,
                      "prevent_download_type": 2,
                      "share_type": 0,
                      "show_progress_bar": 1,
                      "timer_status": 1
                    },
                    "video_labels": null,
                    "video_reply_info": {
                      "alias_comment_id": 6951848398958511000,
                      "aweme_id": 6944028931875950000,
                      "comment_id": 6951589702684344000
                    },
                    "video_text": [],
                    "with_promotional_music": false,
                    "without_watermark": false
                  },
                  "aweme_id": "6944028931875949829",
                  "cid": "6951848398958510853",
                  "create_time": 1618603631,
                  "digg_count": 0,
                  "is_author_digged": false,
                  "label_list": null,
                  "label_text": "Creator",
                  "label_type": 1,
                  "reply_comment": null,
                  "reply_id": "6951589702684344325",
                  "reply_to_reply_id": "0",
                  "status": 1,
                  "text": "Reply to @shannindelgado #pointedpencalligraphy #asmr #flourishedcalligraphy #satisfyingvideo #oddlysatifyingvideos #foryoupage #fyp #smallbusiness",
                  "text_extra": [
                    {
                      "end": 24,
                      "hashtag_id": "",
                      "hashtag_name": "",
                      "sec_uid": "MS4wLjABAAAAnb0HqFEnQ4EwP1V8W17PjVAamK5BOQGUiLzrFbgVR2Ry9Vb4v2AR9blveSLbQYEN",
                      "start": 9,
                      "user_id": "6766766078486184966"
                    }
                  ],
                  "user": {
                    "accept_private_policy": false,
                    "account_region": "",
                    "ad_cover_url": null,
                    "apple_account": 0,
                    "authority_status": 0,
                    "avatar_168x168": {
                      "height": 720,
                      "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "url_list": [
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_168x168.webp?x-expires=1619028000&x-signature=60lRwultH4Dz05gLLjvS7vXgPP4%3D",
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_168x168.jpeg?x-expires=1619028000&x-signature=vSD3gWQa3ah%2FkTGq9nJVePk3tr0%3D"
                      ],
                      "width": 720
                    },
                    "avatar_300x300": {
                      "height": 720,
                      "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "url_list": [
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_300x300.webp?x-expires=1619028000&x-signature=Qql3QQZ5mAljU9GnJrrXhmPDC7E%3D",
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_300x300.jpeg?x-expires=1619028000&x-signature=zrIDS8BfKHbhQfje7FEO716CdF0%3D"
                      ],
                      "width": 720
                    },
                    "avatar_larger": {
                      "height": 720,
                      "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "url_list": [
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_1080x1080.webp?x-expires=1619028000&x-signature=c0v1GbodJPwgw4zAvxZWSYB7Ypc%3D",
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_1080x1080.jpeg?x-expires=1619028000&x-signature=CYje1kModS4KaRAdSjewVLOv1L0%3D"
                      ],
                      "width": 720
                    },
                    "avatar_medium": {
                      "height": 720,
                      "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "url_list": [
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_720x720.webp?x-expires=1619028000&x-signature=2o642kL0qItHBcpax5RNhQbt1n8%3D",
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_720x720.jpeg?x-expires=1619028000&x-signature=QAV29irQeBRKfrY9%2F8b%2FHXwyB%2BE%3D"
                      ],
                      "width": 720
                    },
                    "avatar_thumb": {
                      "height": 720,
                      "uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                      "url_list": [
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_100x100.webp?x-expires=1619028000&x-signature=vCzZpy0K3G0OddM%2B1WwAHJqFFsw%3D",
                        "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b~c5_100x100.jpeg?x-expires=1619028000&x-signature=xkVEHem9QkYHbO3%2B0NAMEvwSilo%3D"
                      ],
                      "width": 720
                    },
                    "avatar_uri": "tos-maliva-avt-0068/1c9de4144573c60859ffd71335cdd31b",
                    "aweme_count": 0,
                    "bind_phone": "",
                    "bold_fields": null,
                    "can_set_geofencing": null,
                    "cha_list": null,
                    "comment_filter_status": 0,
                    "comment_setting": 0,
                    "commerce_user_level": 0,
                    "cover_url": [
                      {
                        "height": 720,
                        "uri": "musically-maliva-obj/1612555907887110",
                        "url_list": [
                          "https://p16-amd-va.tiktokcdn.com/obj/musically-maliva-obj/1612555907887110"
                        ],
                        "width": 720
                      }
                    ],
                    "create_time": 0,
                    "custom_verify": "",
                    "cv_level": "",
                    "download_prompt_ts": 0,
                    "download_setting": 0,
                    "duet_setting": 0,
                    "enterprise_verify_reason": "",
                    "events": null,
                    "favoriting_count": 0,
                    "fb_expire_time": 0,
                    "follow_status": 0,
                    "follower_count": 0,
                    "follower_status": 0,
                    "followers_detail": null,
                    "following_count": 0,
                    "geofencing": null,
                    "google_account": "",
                    "has_email": false,
                    "has_facebook_token": false,
                    "has_insights": false,
                    "has_orders": false,
                    "has_twitter_token": false,
                    "has_youtube_token": false,
                    "hide_search": false,
                    "homepage_bottom_toast": null,
                    "ins_id": "rd_calligraphy",
                    "is_ad_fake": false,
                    "is_block": false,
                    "is_discipline_member": false,
                    "is_phone_binded": false,
                    "is_star": false,
                    "item_list": null,
                    "language": "en",
                    "live_agreement": 0,
                    "live_commerce": false,
                    "live_verify": 0,
                    "mutual_relation_avatars": null,
                    "need_points": null,
                    "need_recommend": 0,
                    "nickname": "Raquel",
                    "platform_sync_info": null,
                    "prevent_download": false,
                    "qa_status": 0,
                    "react_setting": 0,
                    "region": "US",
                    "relative_users": null,
                    "room_id": 0,
                    "search_highlight": null,
                    "sec_uid": "MS4wLjABAAAAjEeVQDYvGX8tfiNwum_aSMpbXa9-qFEh-F1pvs4IqiRUyXHPqgHeZqV4eAfQheEi",
                    "secret": 0,
                    "shield_comment_notice": 0,
                    "shield_digg_notice": 0,
                    "shield_follow_notice": 0,
                    "short_id": "0",
                    "show_image_bubble": false,
                    "signature": "www.rdcalligraphy.com\nProfessional calligrapher and engraver",
                    "special_lock": 1,
                    "status": 1,
                    "stitch_setting": 0,
                    "total_favorited": 0,
                    "tw_expire_time": 0,
                    "twitter_id": "",
                    "twitter_name": "",
                    "type_label": null,
                    "uid": "6867005556525237253",
                    "unique_id": "rd_calligraphy",
                    "unique_id_modify_time": 1618944859,
                    "user_canceled": false,
                    "user_mode": 1,
                    "user_period": 0,
                    "user_rate": 1,
                    "user_tags": null,
                    "verification_type": 0,
                    "verify_info": "",
                    "video_icon": {
                      "height": 720,
                      "uri": "",
                      "url_list": [],
                      "width": 720
                    },
                    "white_cover_url": null,
                    "with_commerce_entry": false,
                    "with_shop_entry": false,
                    "youtube_channel_id": "",
                    "youtube_channel_title": "",
                    "youtube_expire_time": 0
                  },
                  "user_buried": false,
                  "user_digged": 0
                }
              ],
              "reply_comment_total": 1,
              "reply_id": "0",
              "reply_to_reply_id": "0",
              "status": 1,
              "stick_position": 0,
              "text": "PLEASE DO NOAH",
              "text_extra": [],
              "user": {
                "accept_private_policy": false,
                "account_region": "",
                "ad_cover_url": null,
                "apple_account": 0,
                "authority_status": 0,
                "avatar_168x168": {
                  "height": 720,
                  "uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                  "url_list": [
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_168x168.webp?x-expires=1619028000&x-signature=6yOvHjqkkU0AxLwlr7qf8FLUN7o%3D",
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_168x168.jpeg?x-expires=1619028000&x-signature=ZQkcxl8GIaKBAnKqPqphovg80fU%3D"
                  ],
                  "width": 720
                },
                "avatar_300x300": {
                  "height": 720,
                  "uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                  "url_list": [
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_300x300.webp?x-expires=1619028000&x-signature=WSmqQtTWKCAlfdJTx2hWnrT6L14%3D",
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_300x300.jpeg?x-expires=1619028000&x-signature=AX1rgFdka489LTfvsnvetnF4BMM%3D"
                  ],
                  "width": 720
                },
                "avatar_larger": {
                  "height": 720,
                  "uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                  "url_list": [
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_1080x1080.webp?x-expires=1619028000&x-signature=sJnGnuK6Edlw1eFhE8W77tGRid0%3D",
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_1080x1080.jpeg?x-expires=1619028000&x-signature=Ka1nbzuVwhlR%2B1USElFlI6RS4%2Fo%3D"
                  ],
                  "width": 720
                },
                "avatar_medium": {
                  "height": 720,
                  "uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                  "url_list": [
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_720x720.webp?x-expires=1619028000&x-signature=C8ycU7h0jRMaIEXNyU%2F1L%2BDtAcg%3D",
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_720x720.jpeg?x-expires=1619028000&x-signature=1lNpKtA7QHxPbjJV9yVZtmAOANg%3D"
                  ],
                  "width": 720
                },
                "avatar_thumb": {
                  "height": 720,
                  "uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                  "url_list": [
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_100x100.webp?x-expires=1619028000&x-signature=Q4RETb5EMdPuTfxguzuM0Zamv3s%3D",
                    "https://p16-sign-va.tiktokcdn.com/tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06~c5_100x100.jpeg?x-expires=1619028000&x-signature=YiY1KdA9NwWZNIZnJ8W8qUjlI4E%3D"
                  ],
                  "width": 720
                },
                "avatar_uri": "tos-maliva-avt-0068/7c211d02587c71496f19c6237db01a06",
                "aweme_count": 0,
                "bind_phone": "",
                "bold_fields": null,
                "can_set_geofencing": null,
                "cha_list": null,
                "comment_filter_status": 0,
                "comment_setting": 0,
                "commerce_user_level": 0,
                "cover_url": [
                  {
                    "height": 720,
                    "uri": "musically-maliva-obj/1612555907887110",
                    "url_list": [
                      "https://p16-amd-va.tiktokcdn.com/obj/musically-maliva-obj/1612555907887110"
                    ],
                    "width": 720
                  }
                ],
                "create_time": 0,
                "custom_verify": "",
                "cv_level": "",
                "download_prompt_ts": 0,
                "download_setting": 0,
                "duet_setting": 0,
                "enterprise_verify_reason": "",
                "events": null,
                "favoriting_count": 0,
                "fb_expire_time": 0,
                "follow_status": 0,
                "follower_count": 0,
                "follower_status": 0,
                "followers_detail": null,
                "following_count": 0,
                "geofencing": null,
                "google_account": "",
                "has_email": false,
                "has_facebook_token": false,
                "has_insights": false,
                "has_orders": false,
                "has_twitter_token": false,
                "has_youtube_token": false,
                "hide_search": false,
                "homepage_bottom_toast": null,
                "ins_id": "_shannindelgado",
                "is_ad_fake": false,
                "is_block": false,
                "is_discipline_member": false,
                "is_phone_binded": false,
                "is_star": false,
                "item_list": null,
                "language": "en",
                "live_agreement": 0,
                "live_commerce": false,
                "live_verify": 0,
                "mutual_relation_avatars": null,
                "need_points": null,
                "need_recommend": 0,
                "nickname": "Shannin Delgado",
                "platform_sync_info": null,
                "prevent_download": false,
                "qa_status": 1,
                "react_setting": 0,
                "region": "US",
                "relative_users": null,
                "room_id": 0,
                "search_highlight": null,
                "sec_uid": "MS4wLjABAAAAnb0HqFEnQ4EwP1V8W17PjVAamK5BOQGUiLzrFbgVR2Ry9Vb4v2AR9blveSLbQYEN",
                "secret": 0,
                "shield_comment_notice": 0,
                "shield_digg_notice": 0,
                "shield_follow_notice": 0,
                "short_id": "0",
                "show_image_bubble": false,
                "signature": "GIVEAWAY: see last insta post\nMiami / 🇻🇪 \nBusiness only: sdelgadox@icloud.com",
                "special_lock": 1,
                "status": 1,
                "stitch_setting": 0,
                "total_favorited": 0,
                "tw_expire_time": 0,
                "twitter_id": "",
                "twitter_name": "",
                "type_label": null,
                "uid": "6766766078486184966",
                "unique_id": "shannindelgado",
                "unique_id_modify_time": 1618944859,
                "user_canceled": false,
                "user_mode": 1,
                "user_period": 0,
                "user_rate": 1,
                "user_tags": null,
                "verification_type": 0,
                "verify_info": "",
                "video_icon": {
                  "height": 720,
                  "uri": "",
                  "url_list": [],
                  "width": 720
                },
                "white_cover_url": null,
                "with_commerce_entry": false,
                "with_shop_entry": false,
                "youtube_channel_id": "UCtz-sDtRKThViZDdZEeyYOA",
                "youtube_channel_title": "Shannin Delgado",
                "youtube_expire_time": 0
              },
              "user_buried": false,
              "user_digged": 0
            }
          ],
          "cursor": 10,
          "extra": {
            "fatal_item_ids": null,
            "now": 1618944859000
          },
          "has_more": 1,
          "log_pb": {
            "impr_id": "20210420185419010189073069504807DB"
          },
          "reply_style": 2,
          "status_code": 0,
          "top_gifts": null,
          "total": 3742
        }';
        $data = json_decode($data);
        foreach($data->comments as $c) {
          Intent::create(
              [
                  'campaign_source_id' => $campaignSource->id, 
                  'nickname' => $c->user->nickname, 
                  'region' => $c->user->region,
                  'language' => $c->user->language,
                  'picture' => $c->user->avatar_thumb->url_list[0],
                  'text' => $c->text,
                  'cid' => $c->cid,
                  'comment_at' => date('Y/m/d H:i:s', $c->create_time)
              ]
          );
        }
        DB::commit();

        return response()->json([
            'status' => true
        ]);
    }
}
