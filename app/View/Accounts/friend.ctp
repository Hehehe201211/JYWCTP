<script type="text/javascript">
{literal}
$(document).ready(function(){
    $("body").append($("#jsxxxq1"));
/*
	$(".btn .btnCon").click(function(){
		bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
	});
*/
    //站内信
    $(".btn .btnCon").live('click', function(){
        $parent = $(this).parent().parent();
        var name = $parent.find('.friendName').html();
        var target_members_id = $parent.find('.friend_members_id').val();
        $('#jsxxxq1 .biaotit').html('收件人: ' + name);
        $('#receiver').val(target_members_id);
        bgKuang("#jsxxxq1","#jsxxxq1 .closeDiv");
    });
    
    var errorStr = '<span class="checkError" style="color:red">请输入此项目</span>';
    $("#sendMsgBtn").click(function(){
        $('#message .checkError').remove();
        if ($('#title').val().trim() == "") {
            $('#title').after(errorStr);
            return 0;
        }
        if ($('#content').val().trim() == "") {
            $('#content').after(errorStr);
            return 0;
        }
        $.ajax({
            url : '/sms/addMsg',
            type : 'post',
            data : $('#message').serializeArray(),
            success : function(data){
                var result = eval("("+data+")");
                if (result.result == "OK") {
                    alert(result.msg);
                    $('.jsxxxqB .closeDiv').click();
                } else {
                    alert(result.msg);
                }
            }
        });
    });
    
	$(".contacts-list .btn .inp").live("click",function(){
		$(this).parent().hide();
		$(this).parent().next().show();
	});
	/*
	$(".contacts-list .btn .btnSave").live("click",function(){
		alert("分组已更改。");
		$(this).parent().hide();
		$(this).parent().prev().show();
	});
	*/
	$(".contacts-list .btn .btnCancle").live("click",function(){
		$(this).parent().hide();
		$(this).parent().prev().show();
	});
	$("body").append($("#jsxxxqA"));	
	$("body").append($("#jsxxxqE"));	
	$("#add").click(function(){
		bgKuang("#jsxxxqA",".jsxxxqB .closeDiv");			
	});
	$("#edit").click(function(){
		var id = $('#friendGroup').val();
		if (id == "" || id == 0) {
            alert('此分组名称不能更改！');
        } else {
			bgKuang("#jsxxxqE",".jsxxxqB .closeDiv");		
		}
	});
    $('#delete').click(function(){
        var id = $('#friendGroup').val();
        var name = $('#friendGroup option:selected').html();
        if (id == "" || id == 0) {
            alert('此分组不能删除！');
        } else {
            if(confirm('你真的要删除[' + name + ']?')) {
                $.ajax({
                   url : '/friends/deleteFriendGroup',
                   type : 'post',
                   data : 'id=' + id,
                   success : function(data) {
                       var result = eval("("+data+")");
                       if (result.result == "OK") {
                            $('.friSortGroup option').each(function(e){
                                if($(this).attr('value') == id) {
                                    $(this).remove();
                                }
                            });
                            alert(result.msg);
                        } else {
                            alert(result.msg);
                        }
                   }
               });
            }
        }
        
    });
    $('#friendGroup').change(function(){
        var group_id = $('#friendGroup').val();
        $('#result').load('/accounts/friend', {'group':[group_id]}, function(){});
    });
    
    //修改朋友的分组
    $('.changeGroup').live('click', function(){
        var friend_members_id = $(this).parent().find('.friend_members_id').val();
        var friend_groups_id = $(this).parent().find('.friSortGroup').val();
        $(this).parent().hide();
        $(this).parent().prev().show();
        $.ajax({
            url : '/friends/setFriendGroup',
            type : 'post',
            data : 'friend_members_id=' + friend_members_id + '&friend_groups_id=' + friend_groups_id,
            success : function(data) {
                var result = eval("("+data+")");
                if (result.result == "OK") {
                    alert(result.msg);
                } else {
                    alert(result.msg);
                }
            }
        });
    });
    //delete friend
    $('.deleteFriend').live('click', function(){
        $parent = $(this).parent().parent();
        var friendName = $parent.find('.friendName').html();
        var friend_members_id = $parent.find('.friend_members_id').val();
        if (confirm('你真的要把好友:' + friendName + '删除?')) {
            $.ajax({
                url : '/friends/deleteFriend',
                type : 'post',
                data : 'friend_members_id=' + friend_members_id,
                success : function(data) {
                    var result = eval("("+data+")");
                    if (result.result == "OK") {
                        $('#result').load('/accounts/friend', $('#searchOpt').serializeArray(), function(){});
                        alert(result.msg);
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    });
    
});
function addGroup(){
	   var name = $("#newName").val();
	   $('.jsxxxqB .closeDiv').click();
	   if (name != null) {
	       $.ajax({
	           url : '/friends/addFriendGroup',
	           type : 'post',
	           data : 'name=' + name,
	           success : function(data) {
	               var result = eval("("+data+")");
                   if (result.result == "OK") {
                        var opt = '<option value="' + data.id  + '">' + name + '</option>';
                        $('.friSortGroup').append(opt)
                        alert(result.msg);
                    } else {
                        alert(result.msg);
                    }
	           }
	       });
	   }
	}
	function editGroup(){
       var name = $("#editName").val();
	   $('.jsxxxqB .closeDiv').click();
       if (name != null) {
            var id = $('#friendGroup').val();            
			 $.ajax({
			 url : '/friends/editFriendGroupName',
			 type : 'post',
			 data : 'name=' + name + '&id=' + id,
			 success : function(data) {
				 var result = eval("("+data+")");
				 if (result.result == "OK") {
					  $('.friSortGroup option').each(function(e){
						  if($(this).attr('value') == id) {
							  $(this).html(name);
						  }
					  });
					  alert(result.msg);
				  } else {
					  alert(result.msg);
				}
			 }
		 });
       }
    }
{/literal}
</script>

<div class="zy_z">
    <div class="zy_zs">
        <p>
            <a href="new-hyzy.html">我的聚业务</a>&gt;&gt;
            <a href="grxxxg.html.html">账号管理</a>&gt;&gt;
            <a href="#">好友管理</a>
        </p>
        <!--<div class="zy_zszl"></div>-->
    </div>
    <div class="biaotit"><a href="/accounts/invite" class="blue">邀请好友</a>我的好友</div>
    <form id="searchOpt">
    <p class="sort">分组查看：
        <select class="friSortGroup" id="friendGroup" name="group">
          <option value="">全部</option>
          <option value="0" id="none">未分组</option>
          {foreach $groups as $group}
            <option value="{$group.FriendGroup.id}">{$group.FriendGroup.name}</option>
          {/foreach}
        </select>
        <a href="javascript:void(0)" id="add">添加分组</a>&nbsp;&nbsp;
        <a href="javascript:void(0)" id="edit">编辑</a>&nbsp;&nbsp;
        <a href="javascript:void(0)" id="delete">删除</a>
    </p>
    {$form = ['isForm' => true, 'inline' => true]}
    {$options = ['update' => '#result', 'evalScripts' => true, 'dataExpression' => true, 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Paginator->options($options)}
    {$paginatorParams = $this->Paginator->params()}
    {if $paginatorParams['count'] > 0}
    <div id="result">
        <ul class="contacts-list clear" id="user_list_ul">
        {foreach $friendships as $friend}
            <li class="contacts-item">
                <div class="img">
                    <a href="/accounts/fdetail?fid={$friend.Friendship.friend_members_id}" title="好友资料">
                        <img alt="好友" src="{$this->webroot}img/tx.jpg">
                    </a>
                </div>
                <div class="name">
                    <a href="/accounts/fdetail?fid={$friend.Friendship.friend_members_id}" title="好友资料" class="friendName">{$friend.Attribute.name}（{$friend.Member.nickname}）</a>
                    <br />{$friend.Attribute.company}<br />业务员<br />进行过&nbsp;
                    <a href="javascript:void(0)" titlt="交易记录">8</a>&nbsp;笔交易
                </div>
                <div class="btn btns">
                    <a href="javascript:void(0)" class="btnCon">联系</a>
                    <a href="javascript:void(0)" class="deleteFriend" >删除</a>
                    <a href="javascript:void(0)" class="inp" >更改分组</a>
                </div>
                <div class="btn groupNC">
                    <select class="friSortSet friSortGroup">
                        <option value="0" id="none">未分组</option>
                      {foreach $groups as $group}
                        <option value="{$group.FriendGroup.id}" {if $friend.Friendship.friend_groups_id == $group.FriendGroup.id}selected="selected"{/if}>{$group.FriendGroup.name}</option>
                      {/foreach}
                    </select>
                    <input type="hidden" class="friend_members_id" value="{$friend.Friendship.friend_members_id}" />
                    <a href="javascript:void(0)" class="btnSave changeGroup">保存</a>
                    <a href="javascript:void(0)" class="btnCancle">取消</a>
                </div>
            </li>
        {/foreach}
        </ul>
        <div class="fanyea">
            {if $paginatorParams['prevPage']}
                <div class="dd_span">{$this->Paginator->prev('上一页', array(), null, null)}</div>
            {/if}
            <div class="dd_ym">
                <label>每页显示：</label>
                <select name="pageSize" id="pageSize">
                    <option value="2" {if $pageSize == "10"} selected {/if}>10</option>
                    <option value="20" {if $pageSize == "20"} selected {/if}>20</option>
                    <option value="50" {if $pageSize == "50"} selected {/if}>50</option>
                    <option value="100" {if $pageSize == "100"} selected {/if}>100</option>
                </select>
            </div>
            <div class="dd_ym11">
                <font>共{$paginatorParams['count']}条</font>
                <font>第{$paginatorParams['page']}/{$paginatorParams['pageCount']}页</font>
                <input type="text" id="jump" name="jump" value="{if isset($jump)}{$jump}{/if}">
                <div class="dd_span1"><a href="javascript:void(0)" id="jumpButton">跳转</a></div>
            </div>
            {if $paginatorParams['nextPage']}
                <div class="dd_span">{$this->Paginator->next('下一页', array(), null, array())}</div>
            {/if}
        </div>
    </div>
    </form>
    {$pageSizeRequestUrl = ['action' => $this->request->params['action'], 'setPageSize' => 1]}
    {$jumpButtonRequestUrl = ['action' => $this->request->params['action']]}
    {$requestOpt = ['async' => true, 'dataExpression' => true, 'update' => '#result', 'method' => 'post', 'data' => $this->Js->get('#searchOpt')->serializeForm($form)]}
    {$this->Js->get('#pageSize')->event('change', $this->Js->request($pageSizeRequestUrl, $requestOpt))}
    {$this->Js->get('#jumpButton')->event('click', $this->Js->request($jumpButtonRequestUrl, $requestOpt))}
    {$this->Js->writeBuffer()}
    {else}
没有符合条件的信息。
    {/if}
</div>

<div class="jsxxxq jsxxxqB" id="jsxxxq1"> <a href="#" class="closeDiv">&nbsp;</a>
    <div class="biaotit" ></div>
    <form id="message">
        <div class="sjle">
            <dl>
              <dt>
                <label>主题</label>
                <input type="hidden" name="type" id="type" value="1" />
                <input type="hidden" name="receiver" id="receiver" />
                <input type="text" class="inpTextBox" name="title" id="title">
              </dt>
              <dt>
                <label><font class="facexh">*</font>内容</label>
                <textarea name="content" id="content"></textarea>
              </dt>
            </dl>
        </div>
  </form>
  <div class="divBtnContainer clear" style="width:200px;">
  <a class="zclan zclan7" href="javascript:void(0)" id="sendMsgBtn">发送</a>
  <a class="zclan zclan7" href="javascript:void(0)" onclick="var a=$('.jsxxxqB .closeDiv').click();">关闭</a>
  </div>
  <div class="clear">&nbsp;</div>
</div>
<div class="jsxxxq jsxxxqB" id="jsxxxqA" style="width:350px;"> <a href="#" class="closeDiv">&nbsp;</a>
      <div class="biaotit">添加分组</div>
      <div class="prompt">
        <label>新分组名</label>
        <input type="text" class="inpTextBox" id="newName">
      </div>
      <div class="divBtnContainer clear" style="width:200px;"><a class="zclan zclan7" href="javascript:;" onclick="addGroup()">确定</a><a class="zclan zclan7" href="javascript:;" onclick="$('.jsxxxqB .closeDiv').click();">取消</a></div>
    </div>
    <div class="jsxxxq jsxxxqB" id="jsxxxqE" style="width:350px;"> <a href="#" class="closeDiv">&nbsp;</a>
      <div class="biaotit">编辑分组名</div>
      <div class="prompt">
        <label>新分组名</label>
        <input type="text" class="inpTextBox" id="editName">
      </div>
      <div class="divBtnContainer clear" style="width:200px;"><a class="zclan zclan7" href="javascript:;" onclick="editGroup()">确定</a><a class="zclan zclan7" href="javascript:;" onclick="$('.jsxxxqB .closeDiv').click();">取消</a></div>
    </div>