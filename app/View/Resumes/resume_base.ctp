 <tbody> 
    <tr>
              <td width="49" class="tlt tltL">姓名：</td>
              <td width="74">{$resumeBase.ResumeBase.name}</td>
              <td width="47" class="tlt" tltL>联系<br />
                电话：</td>
              <td colspan="3" >{$resumeBase.ResumeBase.telephone}</td>
              <td width="48" class="tlt tltL">国籍：</td>
              <td colspan="3">{$resumeBase.ResumeBase.nationality}</td>
              <td width="78" rowspan="2"><div align="center"><img width="112" height="124" alt="portrait" src="{$this->webroot}img/tx.jpg"></div></td>
            </tr>
            <tr>
              <td class="tlt tltL">性别：</td>
              <td >{if $resumeBase.ResumeBase.sex == 1}男{else}女{/if}</td>
              <td class="tlt tltL">联系<br />
                地址：</td>
              <td colspan="3" >{$resumeBase.ResumeBase.address}</td>
              <td class="tlt tltL">电子<br />
                邮箱：</td>
              <td colspan="3" >{$resumeBase.ResumeBase.email}</td>
            </tr>
            <tr>
              <td class="tlt tltL">出生<br />
                日期：</td>
              <td >{$resumeBase.ResumeBase.birthday|date_format:"%Y-%m-%d"}</td>
              <td class="tlt tltL">民族：</td>
              <td width="39" >{$resumeBase.ResumeBase.ethnic}</td>
              <td width="49" class="tlt tltL">现居<br />
                住地：</td>
              <td colspan="3" >{$provincial_now =  $this->City->cityName($resumeBase.ResumeBase.provincial_now)}
                    {$city_now =  $this->City->cityName($resumeBase.ResumeBase.city_now)}
                    {if $provincial_now == $city_now}
                        {$provincial_now}
                    {else}
                        {$provincial_now} {$city_now}
                    {/if}</td>
              <td width="51" class="tlt tltL">户籍：</td>
              <td colspan="2" >{$provincial_local = $this->City->cityName($resumeBase.ResumeBase.provincial_local)}
                    {$city_local =  $this->City->cityName($resumeBase.ResumeBase.city_local)}
                    {if $provincial_local == $city_local}
                        {$provincial_local}
                    {else}
                        {$provincial_local} {$city_local}
                    {/if}</td>
            </tr>
            <tr class="position">
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td width="46"></td>
              <td></td>
              <td width="35"></td>
              <td></td>
              <td width="52"></td>
              <td></td>
            </tr>
			</tbody>