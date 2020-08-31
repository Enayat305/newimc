<?php

namespace Modules\Essentials\Http\Controllers;

use App\Category;
use App\User;
use App\Utils\ModuleUtil;
use App\Utils\TransactionUtil;
use Illuminate\Routing\Controller;
use Menu;
use Modules\Essentials\Entities\EssentialsTodoComment;
use Modules\Essentials\Entities\DocumentShare;

class DataController extends Controller
{
    /**
     * Parses notification message from database.
     * @return array
     */
    public function parse_notification($notification)
    {
        $notification_data = [];
        if ($notification->type ==
            'Modules\Essentials\Notifications\DocumentShareNotification') {
            $notifiction_data = DocumentShare::documentShareNotificationData($notification->data); 
            $notification_data = [
                'msg' => $notifiction_data['msg'],
                'icon_class' => $notifiction_data['icon'],
                'link' => $notifiction_data['link'],
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans()
            ];
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\NewMessageNotification') {
            $data = $notification->data;
            $msg = __('essentials::lang.new_message_notification', ['sender' => $data['from']]);

            $notification_data = [
                'msg' => $msg,
                'icon_class' => 'fas fa-envelope bg-green',
                'link' => action('\Modules\Essentials\Http\Controllers\EssentialsMessageController@index'),
                'read_at' => $notification->read_at,
                'created_at' => $notification->created_at->diffForHumans()
            ];
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\NewLeaveNotification') {
            $data = $notification->data;

            $employee = User::find($data['applied_by']);

            if (!empty($employee)) {
                $msg = __('essentials::lang.new_leave_notification', ['employee' => $employee->user_full_name, 'ref_no' => $data['ref_no']]);

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-user-times bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\EssentialsLeaveController@index'),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\LeaveStatusNotification') {
            $data = $notification->data;

            $admin = User::find($data['changed_by']);

            if (!empty($admin)) {
                $msg = __('essentials::lang.status_change_notification', ['status' => $data['status'], 'ref_no' => $data['ref_no'], 'admin' => $admin->user_full_name]);

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-user-times bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\EssentialsLeaveController@index'),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\PayrollNotification') {
            $data = $notification->data;

            $month = \Carbon::createFromFormat('m', $data['month'])->format('F');

            $msg = '';

            $created_by = User::find($data['created_by']);

            if (!empty($created_by)) {
                if ($data['action'] == 'created') {
                    $msg = __('essentials::lang.payroll_added_notification', ['month_year' => $month . '/' . $data['year'], 'ref_no' => $data['ref_no'] , 'created_by' => $created_by->user_full_name]);
                } elseif ($data['action'] == 'updated') {
                    $msg = __('essentials::lang.payroll_updated_notification', ['month_year' => $month . '/' . $data['year'], 'ref_no' => $data['ref_no'], 'created_by' => $created_by->user_full_name]);
                }
                

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-money-bill-alt bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\PayrollController@index'),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\NewTaskNotification') {
            $data = $notification->data;

            $assigned_by = User::find($data['assigned_by']);

            if (!empty($assigned_by)) {
                $msg = __('essentials::lang.new_task_notification', ['assigned_by' => $assigned_by->user_full_name, 'task_id' => $data['task_id']]);

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'ion ion-clipboard bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $data['id']),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\NewTaskCommentNotification') {
            $data = $notification->data;

            $comment = EssentialsTodoComment::with(['task', 'added_by'])->find($data['comment_id']);
            if (!empty($comment)) {
                $msg = __('essentials::lang.new_task_comment_notification', ['added_by' => $comment->added_by->user_full_name, 'task_id' => $comment->task->task_id]);

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-envelope bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $comment->task->id),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        } elseif ($notification->type ==
            'Modules\Essentials\Notifications\NewTaskDocumentNotification') {
            $data = $notification->data;

            $uploaded_by = User::find($data['uploaded_by']);

            if (!empty($uploaded_by)) {
                $msg = __('essentials::lang.new_task_document_notification', ['uploaded_by' => $uploaded_by->user_full_name, 'task_id' => $data['task_id']]);

                $notification_data = [
                    'msg' => $msg,
                    'icon_class' => 'fas fa-file bg-green',
                    'link' => action('\Modules\Essentials\Http\Controllers\ToDoController@show', $data['id']),
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            }
        }

        return $notification_data;
    }

    /**
     * Defines user permissions for the module.
     * @return array
     */
    public function user_permissions()
    {
        return [
            [
                'value' => 'essentials.create_message',
                'label' => __('essentials::lang.create_message'),
                'default' => false
            ],
            [
                'value' => 'essentials.view_message',
                'label' => __('essentials::lang.view_message'),
                'default' => false
            ],
            [
                'value' => 'essentials.approve_leave',
                'label' => __('essentials::lang.approve_leave'),
                'default' => false
            ],
            [
                'value' => 'essentials.assign_todos',
                'label' => __('essentials::lang.assign_todos'),
                'default' => false
            ],
            [
                'value' => 'essentials.add_allowance_and_deduction',
                'label' => __('essentials::lang.add_allowance_and_deduction'),
                'default' => false
            ]
        ];
    }

    /**
     * Superadmin package permissions
     * @return array
     */
    public function superadmin_package()
    {
        return [
            [
                'name' => 'essentials_module',
                'label' => __('essentials::lang.essentials_module'),
                'default' => false
            ]
        ];
    }

    /**
    * Adds Essentials menus
    * @return null
    */
    public function modifyAPdminMenu()
    {
        $module_util = new ModuleUtil();
        
        $business_id = session()->get('user.business_id');
        $is_essentials_enabled = (boolean)$module_util->hasThePermissionInSubscription($business_id, 'essentials_module');

        if ($is_essentials_enabled) {
            Menu::modify('admin-sidebar-menu', function ($menu) {
                $menu->dropdown(
                    __('essentials::lang.hrm'),
                    function ($sub) {
                        if (auth()->user()->can('add_essentials_leave_type')) {
                            $sub->url(
                                action('\Modules\Essentials\Http\Controllers\EssentialsLeaveTypeController@index'),
                                __('essentials::lang.leave_type'),
                                ['icon' => 'fa fas fa-star', 'active' => request()->segment(2) == 'leave-type']
                            );
                        }
                        
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\EssentialsLeaveController@index'),
                            __('essentials::lang.leave'),
                            ['icon' => 'fa fas fa-user-times', 'active' => request()->segment(2) == 'leave']
                        );
                        
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\AttendanceController@index'),
                            __('essentials::lang.attendance'),
                            ['icon' => 'fa fas fa-check-square', 'active' => request()->segment(2) == 'attendance']
                        );

                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\EssentialsAllowanceAndDeductionController@index'),
                            __('essentials::lang.allowance_and_deduction'),
                            ['icon' => 'fa fas fa-money-bill-alt', 'active' => request()->segment(2) == 'allowance-deduction']
                        );
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\PayrollController@index'),
                            __('essentials::lang.payroll'),
                            ['icon' => 'fa fas fa-money-bill-alt', 'active' => request()->segment(2) == 'payroll']
                        );
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\EssentialsHolidayController@index'),
                            __('essentials::lang.holiday'),
                            ['icon' => 'fa fas fa-suitcase', 'active' => request()->segment(2) == 'holiday']
                        );

                        $sub->url(
                            action('TaxonomyController@index') . '?type=hrm_department',
                            __('essentials::lang.departments'),
                            ['icon' => 'fa fas fa-sitemap', 'active' => request()->get('type') == 'hrm_department']
                        );

                        $sub->url(
                            action('TaxonomyController@index') . '?type=hrm_designation',
                            __('essentials::lang.designations'),
                            ['icon' => 'fa fas fa-user-circle', 'active' => request()->get('type') == 'hrm_designation']
                        );

                        if (auth()->user()->can('edit_essentials_settings')) {
                            $sub->url(
                                action('\Modules\Essentials\Http\Controllers\EssentialsSettingsController@edit'),
                                __('business.settings'),
                                ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(2) == 'hrm' && request()->segment(2) == 'settings']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-users', 'style' => 'background-color: #605ca8 !important;']
                )->order(87);
                $menu->dropdown(
                    __('essentials::lang.essentials'),
                    function ($sub) {
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\ToDoController@index'),
                            __('essentials::lang.todo'),
                            ['icon' => 'fa fas fa-list-ul', 'active' => request()->segment(2) == 'todo']
                        );
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\DocumentController@index'),
                            __('essentials::lang.document'),
                            ['icon' => 'fa fas fa-file', 'active' => request()->segment(2) == 'document' && request()->get('type') != 'memos']
                        );
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\DocumentController@index') .'?type=memos',
                            __('essentials::lang.memos'),
                            ['icon' => 'fa fas fa-envelope-open', 'active' => request()->segment(2) == 'document' && request()->get('type') == 'memos']
                        );
                        $sub->url(
                            action('\Modules\Essentials\Http\Controllers\ReminderController@index'),
                            __('essentials::lang.reminders'),
                            ['icon' => 'fa fas fa-bell', 'active' => request()->segment(2) == 'reminder']
                        );
                        if (auth()->user()->can('essentials.view_message') || auth()->user()->can('essentials.create_message')) {
                            $sub->url(
                                action('\Modules\Essentials\Http\Controllers\EssentialsMessageController@index'),
                                __('essentials::lang.messages'),
                                ['icon' => 'fa fas fa-comments', 'active' => request()->segment(2) == 'messages']
                            );
                        }
                        if (auth()->user()->can('edit_essentials_settings')) {
                            $sub->url(
                                action('\Modules\Essentials\Http\Controllers\EssentialsSettingsController@edit'),
                                __('business.settings'),
                                ['icon' => 'fa fas fa-cogs', 'active' => request()->segment(2) == 'hrm' && request()->segment(2) == 'settings']
                            );
                        }
                    },
                    ['icon' => 'fa fas fa-check-circle', 'style' => 'background-color: #001f3f !important;']
                )->order(87);
            });
        }
    }

    /**
    * Function to add essential module taxonomies
    * @return array
    */
    public function addTaxonomies()
    {
        return [
            'hrm_department' => [
                'taxonomy_label' =>  __('essentials::lang.department'),
                'heading' => __('essentials::lang.departments'),
                'sub_heading' => __('essentials::lang.manage_departments'),
                'enable_taxonomy_code' => true,
                'taxonomy_code_label' => __('essentials::lang.department_id'),
                'taxonomy_code_help_text' => __('essentials::lang.department_code_help'),
                'enable_sub_taxonomy' => false
            ],

            'hrm_designation' => [
                'taxonomy_label' =>  __('essentials::lang.designation'),
                'heading' => __('essentials::lang.designations'),
                'sub_heading' => __('essentials::lang.manage_designations'),
                'enable_taxonomy_code' => false,
                'taxonomy_code_help_text' => __('essentials::lang.designation_code_help'),
                'enable_sub_taxonomy' => false
            ]
        ];
    }

    /**
    * Function to generate view parts
    * @param array $data
    *
    */
    public function moduleViewPartials($data)
    {
        if ($data['view'] == 'manage_user.create' || $data['view'] == 'manage_user.edit') {
            $business_id = session()->get('business.id');
            $departments = Category::forDropdown($business_id, 'hrm_department');
            $designations = Category::forDropdown($business_id, 'hrm_designation');

            $user = !empty($data['user']) ? $data['user'] : null;

            return view('essentials::partials.user_form_part', compact('departments', 'designations', 'user'))->render();
        } elseif ($data['view'] == 'manage_user.show') {
            $user = !empty($data['user']) ? $data['user'] : null;
            $user_department = Category::find($user->essentials_department_id);
            $user_designstion = Category::find($user->essentials_designation_id);

            return view('essentials::partials.user_details_part', compact('user_department', 'user_designstion'))->render();
        }
    }

    /**
    * Function to process model after being saved
    * @param array $data['event' => 'Event name', 'model_instance' => 'Model instance']
    *
    */
    public function afterModelSaved($data)
    {
        if ($data['event'] = 'user_saved') {
            $user = $data['model_instance'];
            $user->essentials_department_id = request()->input('essentials_department_id');
            $user->essentials_designation_id = request()->input('essentials_designation_id');
            $user->save();
        }
    }

    public function profitLossReportData($data)
    {
        $business_id = $data['business_id'];
        $location_id = !empty($data['location_id']) ? $data['location_id'] : null;
        $start_date = !empty($data['start_date']) ? $data['start_date'] : null;
        $end_date = !empty($data['end_date']) ? $data['end_date'] : null;

        $total_payroll = $this->__getTotalPayroll(
            $business_id,
            $start_date,
            $end_date,
            $location_id
        );

        $report_data = [
            //left side data
            [
                [
                    'value' => $total_payroll,
                    'label' => __('essentials::lang.total_payroll'),
                    'add_to_net_profit' => true
                ]
            ],

            //right side data
            []
        ];

        return $report_data;
    }

    /**
     * Calculates total payroll
     *
     * @param  int $business_id
     * @param  string $start_date = null
     * @param  string $end_date = null
     * @param  int $location_id = null
     *
     * @return array
     */
    private function __getTotalPayroll(
        $business_id,
        $start_date = null,
        $end_date = null,
        $location_id = null
        ) {
        $transactionUtil = new TransactionUtil();

        $transaction_totals = $transactionUtil->getTransactionTotals(
            $business_id,
            ['payroll'],
            $start_date,
            $end_date,
            $location_id
            );

        return $transaction_totals['total_payroll'];
    }
}
