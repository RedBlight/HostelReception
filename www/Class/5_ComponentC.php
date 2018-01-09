<?php
/** 5 **
 * This class holds html components that should be stored locally on the client
 */

include_once( "4_Component.php" );

Class ComponentC
{
    static $comp = array();
}

// FUNDAMENTAL PARTS

ComponentC::$comp["option_number_1_100"] = <<<'HTML'
<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option><option value="32">32</option><option value="33">33</option><option value="34">34</option><option value="35">35</option><option value="36">36</option><option value="37">37</option><option value="38">38</option><option value="39">39</option><option value="40">40</option><option value="41">41</option><option value="42">42</option><option value="43">43</option><option value="44">44</option><option value="45">45</option><option value="46">46</option><option value="47">47</option><option value="48">48</option><option value="49">49</option><option value="50">50</option><option value="51">51</option><option value="52">52</option><option value="53">53</option><option value="54">54</option><option value="55">55</option><option value="56">56</option><option value="57">57</option><option value="58">58</option><option value="59">59</option><option value="60">60</option><option value="61">61</option><option value="62">62</option><option value="63">63</option><option value="64">64</option><option value="65">65</option><option value="66">66</option><option value="67">67</option><option value="68">68</option><option value="69">69</option><option value="70">70</option><option value="71">71</option><option value="72">72</option><option value="73">73</option><option value="74">74</option><option value="75">75</option><option value="76">76</option><option value="77">77</option><option value="78">78</option><option value="79">79</option><option value="80">80</option><option value="81">81</option><option value="82">82</option><option value="83">83</option><option value="84">84</option><option value="85">85</option><option value="86">86</option><option value="87">87</option><option value="88">88</option><option value="89">89</option><option value="90">90</option><option value="91">91</option><option value="92">92</option><option value="93">93</option><option value="94">94</option><option value="95">95</option><option value="96">96</option><option value="97">97</option><option value="98">98</option><option value="99">99</option><option value="100">100</option>
HTML;

ComponentC::$comp["option_month"] = <<<'HTML'
<option value="01">1-January</option><option value="02">2-February</option><option value="03">3-March</option><option value="04">4-April</option><option value="05">5-May</option><option value="06">6-June</option><option value="07">7-July</option><option value="08">8-August</option><option value="09">9-September</option><option value="10">10-October</option><option value="11">11-November</option><option value="12">12-December</option>
HTML;

ComponentC::$comp["option_smonth"] = <<<'HTML'
<option value="01">1-Jan</option><option value="02">2-Feb</option><option value="03">3-Mar</option><option value="04">4-Apr</option><option value="05">5-May</option><option value="06">6-Jun</option><option value="07">7-Jul</option><option value="08">8-Aug</option><option value="09">9-Sep</option><option value="10">10-Oct</option><option value="11">11-Nov</option><option value="12">12-Dec</option>
HTML;

ComponentC::$comp["option_day"] = <<<'HTML'
<option value="01">1</option><option value="02">2</option><option value="03">3</option><option value="04">4</option><option value="05">5</option><option value="06">6</option><option value="07">7</option><option value="08">8</option><option value="09">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option>
HTML;

ComponentC::$comp["option_year"] = <<<'HTML'
<option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>
HTML;

ComponentC::$comp["option_lyear"] = <<<'HTML'
<option value="1900">1900</option><option value="1901">1901</option><option value="1902">1902</option><option value="1903">1903</option><option value="1904">1904</option><option value="1905">1905</option><option value="1906">1906</option><option value="1907">1907</option><option value="1908">1908</option><option value="1909">1909</option><option value="1910">1910</option><option value="1911">1911</option><option value="1912">1912</option><option value="1913">1913</option><option value="1914">1914</option><option value="1915">1915</option><option value="1916">1916</option><option value="1917">1917</option><option value="1918">1918</option><option value="1919">1919</option><option value="1920">1920</option><option value="1921">1921</option><option value="1922">1922</option><option value="1923">1923</option><option value="1924">1924</option><option value="1925">1925</option><option value="1926">1926</option><option value="1927">1927</option><option value="1928">1928</option><option value="1929">1929</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option>
HTML;

ComponentC::$comp["option_country"] = <<<'HTML'
<option value="1">Afghanistan</option><option value="2">Albania</option><option value="3">Algeria</option><option value="4">Andorra</option><option value="5">Angola</option><option value="6">Antigua</option><option value="7">Argentina</option><option value="8">Armenia</option><option value="9">Aruba</option><option value="10">Australia</option><option value="11">Austria</option><option value="12">Azerbaijan</option><option value="13">Bahamas, The</option><option value="14">Bahrain</option><option value="15">Bangladesh</option><option value="16">Barbados</option><option value="17">Belarus</option><option value="18">Belgium</option><option value="19">Belize</option><option value="20">Benin</option><option value="21">Bhutan</option><option value="22">Bolivia</option><option value="23">Bosnia Herzegovina</option><option value="24">Botswana</option><option value="25">Brazil</option><option value="26">Brunei</option><option value="27">Bulgaria</option><option value="28">Burkina Faso</option><option value="29">Burma</option><option value="30">Burundi</option><option value="31">Cambodia</option><option value="32">Cameroon</option><option value="33">Canada</option><option value="34">Cape Verde</option><option value="35">Central Africa</option><option value="36">Chad</option><option value="37">Chile</option><option value="38">China</option><option value="39">Colombia</option><option value="40">Comoros</option><option value="41">Congo Democratic</option><option value="42">Congo</option><option value="43">Costa Rica</option><option value="44">Cote d'Ivoire</option><option value="45">Croatia</option><option value="46">Cuba</option><option value="47">Curacao</option><option value="48">Cyprus</option><option value="49">Czech Republic</option><option value="50">Denmark</option><option value="51">Djibouti</option><option value="52">Dominica</option><option value="53">Dominican Republic</option><option value="54">East Timor</option><option value="55">Ecuador</option><option value="56">Egypt</option><option value="57">El Salvador</option><option value="58">Equatorial Guinea</option><option value="59">Eritrea</option><option value="60">Estonia</option><option value="61">Ethiopia</option><option value="62">Fiji</option><option value="63">Finland</option><option value="64">France</option><option value="65">Gabon</option><option value="66">Gambia</option><option value="67">Georgia</option><option value="68">Germany</option><option value="69">Ghana</option><option value="70">Greece</option><option value="71">Grenada</option><option value="72">Guatemala</option><option value="73">Guinea</option><option value="74">Guinea-Bissau</option><option value="75">Guyana</option><option value="76">Haiti</option><option value="77">Holy See</option><option value="78">Honduras</option><option value="79">Hong Kong</option><option value="80">Hungary</option><option value="81">Iceland</option><option value="82">India</option><option value="83">Indonesia</option><option value="84">Iran</option><option value="85">Iraq</option><option value="86">Ireland</option><option value="87">Israel</option><option value="88">Italy</option><option value="89">Jamaica</option><option value="90">Japan</option><option value="91">Jordan</option><option value="92">Kazakhstan</option><option value="93">Kenya</option><option value="94">Kiribati</option><option value="95">Korea North</option><option value="96">Korea South</option><option value="97">Kosovo</option><option value="98">Kuwait</option><option value="99">Kyrgyzstan</option><option value="100">Laos</option><option value="101">Latvia</option><option value="102">Lebanon</option><option value="103">Lesotho</option><option value="104">Liberia</option><option value="105">Libya</option><option value="106">Liechtenstein</option><option value="107">Lithuania</option><option value="108">Luxembourg</option><option value="109">Macau</option><option value="110">Macedonia</option><option value="111">Madagascar</option><option value="112">Malawi</option><option value="113">Malaysia</option><option value="114">Maldives</option><option value="115">Mali</option><option value="116">Malta</option><option value="117">Marshall Islands</option><option value="118">Mauritania</option><option value="119">Mauritius</option><option value="120">Mexico</option><option value="121">Micronesia</option><option value="122">Moldova</option><option value="123">Monaco</option><option value="124">Mongolia</option><option value="125">Montenegro</option><option value="126">Morocco</option><option value="127">Mozambique</option><option value="128">Namibia</option><option value="129">Nauru</option><option value="130">Nepal</option><option value="131">Netherlands</option><option value="132">Netherlands Antilles</option><option value="133">New Zealand</option><option value="134">Nicaragua</option><option value="135">Niger</option><option value="136">Nigeria</option><option value="137">North Korea</option><option value="138">Norway</option><option value="139">Oman</option><option value="140">Pakistan</option><option value="141">Palau</option><option value="142">Palestine</option><option value="143">Panama</option><option value="144">Papua New Guinea</option><option value="145">Paraguay</option><option value="146">Peru</option><option value="147">Philippines</option><option value="148">Poland</option><option value="149">Portugal</option><option value="150">Qatar</option><option value="151">Romania</option><option value="152">Russia</option><option value="153">Rwanda</option><option value="154">Saint Kitts</option><option value="155">Saint Lucia</option><option value="156">Saint Vincent</option><option value="157">Samoa</option><option value="158">San Marino</option><option value="159">Sao Tome</option><option value="160">Saudi Arabia</option><option value="161">Senegal</option><option value="162">Serbia</option><option value="163">Seychelles</option><option value="164">Sierra Leone</option><option value="165">Singapore</option><option value="166">Sint Maarten</option><option value="167">Slovakia</option><option value="168">Slovenia</option><option value="169">Solomon Islands</option><option value="170">Somalia</option><option value="171">South Africa</option><option value="172">South Korea</option><option value="173">South Sudan</option><option value="174">Spain</option><option value="175">Sri Lanka</option><option value="176">Sudan</option><option value="177">Suriname</option><option value="178">Swaziland</option><option value="179">Sweden</option><option value="180">Switzerland</option><option value="181">Syria</option><option value="182">Taiwan</option><option value="183">Tajikistan</option><option value="184">Tanzania</option><option value="185">Thailand</option><option value="186">Timor-Leste</option><option value="187">Togo</option><option value="188">Tonga</option><option value="189">Trinidad</option><option value="190">Tunisia</option><option value="191">Turkey</option><option value="192">Turkmenistan</option><option value="193">Tuvalu</option><option value="194">Uganda</option><option value="195">Ukraine</option><option value="196">UAE</option><option value="197">United Kingdom</option><option value="198">United States</option><option value="199">Uruguay</option><option value="200">Uzbekistan</option><option value="201">Vanuatu</option><option value="202">Venezuela</option><option value="203">Vietnam</option><option value="204">Yemen</option><option value="205">Zambia</option><option value="206">Zimbabwe</option><option value="207">Other</option>
HTML;

// MAIN

ComponentC::$comp["codeport"] = <<<'HTML'
<div id="codeport"></div>
HTML;

ComponentC::$comp["loading"] = <<<'HTML'
Loading <img src='Image/ajaxloading.gif' alt='Loading...' width='16' height='11' />
HTML;

ComponentC::$comp["layout_manager"] = <<<'HTML'
<div id="navbar">
    <div id="logo"></div>
    <div id="infobar"><span id="time"></span>&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;<span id="currency">$ </span><span id="usd" class="val"></span>
        &nbsp;&nbsp;&nbsp;<span id="currency">€ </span><span id="eur" class="val"></span>
        &nbsp;&nbsp;&nbsp;<span id="currency">£ </span><span id="gbp" class="val"></span></div>
    <div id="btnbarl">
        <div id="summary" class="btno">Summary</div><div id="reservations" class="btni">Reservations</div><div id="people" class="btno">People</div><div id="finance" class="btno">Finance</div><div id="statistics" class="btno">Statistics</div>
    </div>
    <div id="welcome">Welcome Manager,<br/><span id="username"></span></div>
    <div id="btnbarr">
        <div id="settings" class="btno">Settings</div><div id="exit" class="btno">Exit</div>
    </div>
</div>
<div id="content"></div>
HTML;

ComponentC::$comp["layout_employee"] = <<<'HTML'
<div id="navbar">
    <div id="logo"></div>
    <div id="infobar"><span id="time"></span>&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;<span id="currency">$ </span><span id="usd" class="val"></span>
        &nbsp;&nbsp;&nbsp;<span id="currency">€ </span><span id="eur" class="val"></span>
        &nbsp;&nbsp;&nbsp;<span id="currency">£ </span><span id="gbp" class="val"></span></div>
    <div id="btnbarl">
        <div id="summary" class="btno">Summary</div><div id="reservations" class="btni">Reservations</div><div id="people" class="btno">People</div><div id="finance" class="btno">Finance</div><div id="statistics" class="btno">Statistics</div>
    </div>
    <div id="welcome">Welcome,<br/><span id="username"></span></div>
    <div id="btnbarr">
        <div id="exit" class="btno">Exit</div>
    </div>
</div>
<div id="content"></div>
HTML;

ComponentC::$comp["modal"] = <<<'HTML'
<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="title"></h4>
      </div>
      <div class="modal-body" id="body"></div>
      <div class="modal-footer" id="btnbar">
      </div>
    </div>
  </div>
</div>
HTML;

ComponentC::$comp["modal_btn_cancel"] = <<<'HTML'
        <div type="button" id="cancel" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Cancel</div>
HTML;

ComponentC::$comp["modal_btn_confirm"] = <<<'HTML'
        <div type="button" id="confirm" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span> Confirm</div>
HTML;

ComponentC::$comp["modal_btn_addnow"] = <<<'HTML'
        <div type="button" id="addnow" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Add Now!</div>
HTML;

ComponentC::$comp["modal_btn_save"] = <<<'HTML'
        <div type="button" id="save" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> Save Changes</div>
HTML;



ComponentC::$comp["page_login"] = <<<'HTML'
<br/><br/><br/>
<img src="Image/logo.png"/>
<br/>
<div class="login-holder">
  <div class="input-group">
    <input id="username" name="username" type="text" class="form-control" placeholder="Username" maxlength="64">
  </div>
  <br/>
  <div class="input-group">
    <input id="password" name="password" type="password" class="form-control" placeholder="Password" maxlength="64">
  </div>
  <br/>
  <div id="captcha"></div>
  <br/>
  <div id="login-btn" class="btn btn-default btn-lg" role="button">Login Now!</div>
  <br/>
</div>
<br/>
<div id="login-alert" class="alert"></div>
HTML;

// SUMMARY

ComponentC::$comp["page_summary"] = <<<'HTML'
<div class="sum-segment" id="arriving">
    <div id="cap"><span class="glyphicon glyphicon-arrow-down"></span> Arriving Reservations</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-source">Source</td>
            <td class="col-person">Person</td>
        </tr>
    </table><div class="sum-date" id="yesterday"></div><table id="yesterday">

    </table><div class="sum-date" id="today"></div><table id="today">

    </table><div class="sum-date" id="tomorrow"></div><table id="tomorrow">

    </table>
</div><div class="sum-segment" id="leaving">
    <div id="cap"><span class="glyphicon glyphicon-arrow-up"></span> Leaving Reservations</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-source">Source</td>
            <td class="col-person">Person</td>
        </tr>
    </table><div class="sum-date" id="yesterday"></div><table id="yesterday">

    </table><div class="sum-date" id="today"></div><table id="today">

    </table><div class="sum-date" id="tomorrow"></div><table id="tomorrow">

    </table>
</div><br/><div class="sum-segment" id="fees">
    <div id="cap"><span class="glyphicon glyphicon-shopping-cart"></span> Unpaid Fees</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-type">Type</td>
            <td class="col-amount">Amount</td>
        </tr>
    </table>
    <table id="fees">

    </table>
</div><div class="sum-segment" id="notes">
    <div id="cap"><span class="glyphicon glyphicon-pushpin"></span> Notes</div>
</div>
HTML;

ComponentC::$comp["summary_row_arriving"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-source"></td>
            <td class="col-person"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_leaving"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-source"></td>
            <td class="col-person"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_fee"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-type"></td>
            <td class="col-amount"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_alldone"] = <<<'HTML'
        <tr>
            <td class="col-alldone">All done!</td>
        </tr>
HTML;

ComponentC::$comp["summary_row_note"] = <<<'HTML'
    <table id="notes">
        <tr class="datarow">
            <td class="col-note"></td>
            <td class="col-action">
                <div class="tablebtn green" id="note-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="note-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["summary_row_noteadd"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-noteadd"><div class="tablebtn green" id="note-add"><span class="glyphicon glyphicon-plus"></span> Add New Note</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["summary_modal_noteadd"] = <<<'HTML'
<div class="input-group">
    <input id="new-note" name="new-note" type="text" class="form-control" placeholder="Enter new note here..." maxlength="3000">
</div>
HTML;

ComponentC::$comp["summary_modal_note_edit"] = <<<'HTML'
<div class="input-group">
    <input id="edit-note" name="edit-note" type="text" class="form-control" maxlength="3000">
</div>
HTML;

ComponentC::$comp["summary_modal_alert"] = <<<'HTML'
<div id="modal-alert" class="alert alert-danger" style="display: inline-block;"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;</div>
HTML;














ComponentC::$comp["page_reservations"] = <<<'HTML'
### Reservations ###
HTML;

ComponentC::$comp["page_people"] = <<<'HTML'
### People ###
HTML;

ComponentC::$comp["page_finance"] = <<<'HTML'
### Finance ###
HTML;

ComponentC::$comp["page_statistics"] = <<<'HTML'
### Statistics ###
HTML;










ComponentC::$comp["page_settings"] = <<<'HTML'
<div id="settings-segment">
    <div id="btnbar"><div class="btno" id="users">
        <span class="glyphicon glyphicon-user"></span> Users
    </div><div class="btno" id="rooms">
        <span class="glyphicon glyphicon-tower"></span> Rooms
    </div><div class="btno" id="sources">
        <span class="glyphicon glyphicon-phone-alt"></span> Booking Sources
    </div><div class="btno" id="fees">
        <span class="glyphicon glyphicon-shopping-cart"></span> Customer Fees
    </div><div class="btno" id="payments">
        <span class="glyphicon glyphicon-transfer"></span> Payments
    </div></div>
    <br/>
    <div id="gutter"></div>
    <div id="body"></div>
</div>
HTML;

// USERS

ComponentC::$comp["settings_row_users_head"] = <<<'HTML'
    <table id="users">
        <tr class="row-users">
            <th class="col-id"># ID</td>
            <th class="col-username">Username</td>
            <th class="col-type">User Type</td>
            <th class="col-action">Actions</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_users"] = <<<'HTML'
    <table id="users">
        <tr class="row-users datarow">
            <td class="col-id"></td>
            <td class="col-username"></td>
            <td class="col-type"></td>
            <td class="col-action">
                <div class="tablebtn green" id="user-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="user-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_users_add"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-add"><div class="tablebtn green" id="user-add"><span class="glyphicon glyphicon-plus"></span> Add New User</div></td>
        </tr>
    </table>
HTML;

// ROOMS

ComponentC::$comp["settings_row_rooms_head"] = <<<'HTML'
    <table id="rooms">
        <tr class="row-rooms">
            <th class="col-id"># ID</td>
            <th class="col-name">Room Name</td>
            <th class="col-type">Room Type</td>
            <th class="col-bedcount">Bed Count</td>
            <th class="col-action">Actions</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_rooms"] = <<<'HTML'
    <table id="rooms">
        <tr class="row-rooms datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-type"></td>
            <td class="col-bedcount"></td>
            <td class="col-action">
                <div class="tablebtn green" id="room-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="room-up"><span class="glyphicon glyphicon-arrow-up"></span> Up</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="room-down"><span class="glyphicon glyphicon-arrow-down"></span> Down</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="room-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_rooms_deleted"] = <<<'HTML'
    <table id="rooms" class="deleted">
        <tr class="row-rooms datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-type"></td>
            <td class="col-bedcount"></td>
            <td class="col-action">
                <div class="tablebtn green" id="room-undelete"><span class="glyphicon glyphicon-share-alt"></span> Undelete</div>
            </td>
        </tr>
    </table>
HTML;
ComponentC::$comp["settings_row_rooms_none"] = <<<'HTML'
    <table id="rooms" class="deleted">
        <tr class="row-rooms datarow">
            <td class="col-none">None!</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_rooms_add"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-add"><div class="tablebtn green" id="room-add"><span class="glyphicon glyphicon-plus"></span> Add New Room</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_rooms_show"] = <<<'HTML'
    <table id="show">
        <tr>
            <td class="col-show"><div class="tablebtn yellow" id="room-show"><span class="glyphicon glyphicon-eye-open"></span> Show Deleted Rooms</div></td>
        </tr>
    </table>
HTML;

// SOURCES

ComponentC::$comp["settings_row_sources_head"] = <<<'HTML'
    <table id="sources">
        <tr class="row-sources">
            <th class="col-id"># ID</td>
            <th class="col-name">Source Name</td>
            <th class="col-action">Actions</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_sources"] = <<<'HTML'
    <table id="sources">
        <tr class="row-sources datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="source-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="source-up"><span class="glyphicon glyphicon-arrow-up"></span> Up</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="source-down"><span class="glyphicon glyphicon-arrow-down"></span> Down</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="source-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_sources_deleted"] = <<<'HTML'
    <table id="sources" class="deleted">
        <tr class="row-sources datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="source-undelete"><span class="glyphicon glyphicon-share-alt"></span> Undelete</div>
            </td>
        </tr>
    </table>
HTML;
ComponentC::$comp["settings_row_sources_none"] = <<<'HTML'
    <table id="sources" class="deleted">
        <tr class="row-sources datarow">
            <td class="col-none">None!</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_sources_add"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-add"><div class="tablebtn green" id="source-add"><span class="glyphicon glyphicon-plus"></span> Add New Source</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_sources_show"] = <<<'HTML'
    <table id="show">
        <tr>
            <td class="col-show"><div class="tablebtn yellow" id="source-show"><span class="glyphicon glyphicon-eye-open"></span> Show Deleted Sources</div></td>
        </tr>
    </table>
HTML;

// FEES

ComponentC::$comp["settings_row_fees_head"] = <<<'HTML'
    <table id="fees">
        <tr class="row-fees">
            <th class="col-id"># ID</td>
            <th class="col-name">Fee Name</td>
            <th class="col-action">Actions</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_fees"] = <<<'HTML'
    <table id="fees">
        <tr class="row-fees datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="fee-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="fee-up"><span class="glyphicon glyphicon-arrow-up"></span> Up</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="fee-down"><span class="glyphicon glyphicon-arrow-down"></span> Down</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="fee-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_fees_deleted"] = <<<'HTML'
    <table id="fees" class="deleted">
        <tr class="row-fees datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="fee-undelete"><span class="glyphicon glyphicon-share-alt"></span> Undelete</div>
            </td>
        </tr>
    </table>
HTML;
ComponentC::$comp["settings_row_fees_none"] = <<<'HTML'
    <table id="fees" class="deleted">
        <tr class="row-fees datarow">
            <td class="col-none">None!</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_fees_add"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-add"><div class="tablebtn green" id="fee-add"><span class="glyphicon glyphicon-plus"></span> Add New Fee</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_fees_show"] = <<<'HTML'
    <table id="show">
        <tr>
            <td class="col-show"><div class="tablebtn yellow" id="fee-show"><span class="glyphicon glyphicon-eye-open"></span> Show Deleted Fees</div></td>
        </tr>
    </table>
HTML;

// PAYMENTS

ComponentC::$comp["settings_row_payments_head"] = <<<'HTML'
    <table id="payments">
        <tr class="row-paymanets">
            <th class="col-id"># ID</td>
            <th class="col-name">Payment Name</td>
            <th class="col-action">Actions</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_payments"] = <<<'HTML'
    <table id="payments">
        <tr class="row-payments datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="payment-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="payment-up"><span class="glyphicon glyphicon-arrow-up"></span> Up</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn blue" id="payment-down"><span class="glyphicon glyphicon-arrow-down"></span> Down</div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="payment-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_payments_deleted"] = <<<'HTML'
    <table id="payments" class="deleted">
        <tr class="row-payments datarow">
            <td class="col-id"></td>
            <td class="col-name"></td>
            <td class="col-action">
                <div class="tablebtn green" id="payment-undelete"><span class="glyphicon glyphicon-share-alt"></span> Undelete</div>
            </td>
        </tr>
    </table>
HTML;
ComponentC::$comp["settings_row_payments_none"] = <<<'HTML'
    <table id="payments" class="deleted">
        <tr class="row-payments datarow">
            <td class="col-none">None!</td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_payments_add"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-add"><div class="tablebtn green" id="payment-add"><span class="glyphicon glyphicon-plus"></span> Add New Payment</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_row_payments_show"] = <<<'HTML'
    <table id="show">
        <tr>
            <td class="col-show"><div class="tablebtn yellow" id="payment-show"><span class="glyphicon glyphicon-eye-open"></span> Show Deleted Payments</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["settings_modal_user_edit"] = <<<'HTML'
<div class="input-group">
    <label for="username">Username:</label>
    <input id="username" name="username" type="text" class="form-control" maxlength="32">
</div>
<br/>
<div class="input-group">
    <label for="type">Usertype:</label>
    <select class="form-control" id="type" name="type">
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
    </select>
</div>
<br/>
<div class="checkbox">
  <label>
    <input type="checkbox" id="changepass">
    Change Password
  </label>
</div>
<div class="input-group" id="password-wrap" style="display:none;">
    <input id="password" name="password" type="text" class="form-control" placeholder="New password..." maxlength="32">
</div>
HTML;

ComponentC::$comp["settings_modal_user_add"] = <<<'HTML'
<div class="input-group">
    <label for="username">Username:</label>
    <input id="username" name="username" type="text" class="form-control" maxlength="32">
</div>
<br/>
<div class="input-group">
    <label for="type">Usertype:</label>
    <select class="form-control" id="type" name="type">
        <option value="Manager">Manager</option>
        <option value="Employee">Employee</option>
    </select>
</div>
<br/>
<div class="input-group">
    <label for="username">Password:</label>
    <input id="password" name="password" type="text" class="form-control" maxlength="32">
</div>
HTML;


// ROOMS

ComponentC::$comp["settings_modal_room_add"] = <<<'HTML'
<div class="input-group">
    <label for="name">Room Name:</label>
    <input id="name" name="name" type="text" class="form-control" maxlength="48">
</div>
<br/>
<div class="input-group">
    <label for="type">Room Type:</label>
    <input id="type" name="type" type="text" class="form-control" maxlength="48">
</div>
<br/>
<div class="input-group">
    <label for="bed">Bed Count:</label>
    <select class="form-control" id="bed" name="bed">{option_number_1_100}</select>
</div>
HTML;

// SOURCES

ComponentC::$comp["settings_modal_source_add"] = <<<'HTML'
<div class="input-group">
    <label for="name">Source Name:</label>
    <input id="name" name="name" type="text" class="form-control" maxlength="48">
</div>
HTML;

// FEES

ComponentC::$comp["settings_modal_fee_add"] = <<<'HTML'
<div class="input-group">
    <label for="name">Fee Name:</label>
    <input id="name" name="name" type="text" class="form-control" maxlength="48">
</div>
HTML;

// PAYMENTS

ComponentC::$comp["settings_modal_payment_add"] = <<<'HTML'
<div class="input-group">
    <label for="name">Payment Name:</label>
    <input id="name" name="name" type="text" class="form-control" maxlength="48">
</div>
HTML;



//=============================================================================
//============================== RESERVATIONS =================================
//=============================================================================

ComponentC::$comp["page_reservations"] = <<<'HTML'
<table id="res-toolbar">
    <tr>
        <td id="left">
	        <div type="button" id="res-btn-addnew"><span class="glyphicon glyphicon-plus gl-green"></span> &nbsp; Add New Reservation</div>
        </td>
        <td id="center">
            <div type="button" id="res-btn-left">
                <span class="glyphicon glyphicon-chevron-left gl-green"></span>
            </div><div id="res-nav">
                Navigate:<br/><select id="res-nav-day"></select> / <select id="res-nav-mon"></select> / <select id="res-nav-yea"></select>
            </div><div type="button" id="res-btn-right">
                <span class="glyphicon glyphicon-chevron-right gl-green"></span>
            </div>
        </td>
        <td id="right">
	        <div type="button" id="res-btn-options"><span class="glyphicon glyphicon-asterisk gl-green"></span> &nbsp; Options</div>
        </td>
    </tr>
</table>
HTML;

ComponentC::$comp["reserv_table_head"] = <<<'HTML'
<table class="res-head">
    <tr>
        <td id="h0">ROOMS \ DAYS &nbsp; <span class="glyphicon glyphicon-info-sign" id="res-legend"></span></td>
        <td id="h1"></td>
        <td id="h2"></td>
        <td id="h3"></td>
        <td id="h4"></td>
        <td id="h5"></td>
        <td id="h6"></td>
        <td id="h7"></td>
    </tr>
</table>
HTML;

ComponentC::$comp["reserv_table_legend"] = <<<'HTML'
<table id="legend" style="display: inline-block;">
    <tr>	<td id="lgn-1">clear block</td>       <td id="lgn-r">Checked in and not left yet.</td>            </tr>
	<tr>	<td id="lgn-2">pale block</td>        <td id="lgn-r">Checked out, or not yet arrived.</td>		  </tr>
	<tr>	<td>&nbsp;</td>						  <td>&nbsp;</td>											  </tr>
    <tr>	<td id="lgn-3">gray background</td>	  <td id="lgn-r">Fees are not paid yet.</td>				  </tr>
	<tr>	<td id="lgn-4">green background</td>  <td id="lgn-r">All fees are paid.</td>					  </tr>
	<tr>	<td id="lgn-5">red background</td>    <td id="lgn-r">Cancelled reservation.</td>				  </tr>
	<tr>	<td>&nbsp;</td>						  <td>&nbsp;</td>											  </tr>
    <tr>	<td id="lgn-6">straight text</td>	  <td id="lgn-r">Main person that made the reservation.</td>  </tr>
	<tr>	<td id="lgn-7">italic text</td>		  <td id="lgn-r">Companions of main person.</td>			  </tr>
</table>
HTML;

ComponentC::$comp["reserv_table_row"] = <<<'HTML'
<table class="res-data">
    <tr>
        <td class="xh"></td>
        <td class="x0"></td>
        <td class="x1"></td>
        <td class="x2"></td>
        <td class="x3"></td>
        <td class="x4"></td>
        <td class="x5"></td>
        <td class="x6"></td>
    </tr>
</table>
HTML;

ComponentC::$comp["reserv_modal_options"] = <<<'HTML'
<div class="checkbox">
  <label>
    <input type="checkbox" id="opt-0">
    Show people count.
  </label>
</div>
<br/>
<div class="checkbox">
  <label>
    <input type="checkbox" id="opt-1">
    Show comapanions.
  </label>
</div>
<br/>
<div class="checkbox">
  <label>
    <input type="checkbox" id="opt-2">
    Show cancelled reservations.
  </label>
</div>
HTML;

ComponentC::$comp["reserv_modal_add"] = <<<'HTML'
<div id="reservadd-segment">
    <div id="r-navbar"><div class="btno" id="main">
        <span class="glyphicon glyphicon-tag"></span> Main
    </div><div class="btno" id="people">
        <span class="glyphicon glyphicon-user"></span> People
    </div><div class="btno" id="stay">
        <span class="glyphicon glyphicon-th-large"></span> Stay
    </div><div class="btno" id="fees">
        <span class="glyphicon glyphicon-shopping-cart"></span> Fees
    </div></div>
    <br/>
    <div id="r-body">
      <div class="r-segment" id="r-segment-main"><div class="r-gutter" id="r-gutter-main"></div>

      </div><div class="r-segment" id="r-segment-people"><div class="r-gutter" id="r-gutter-people"></div>

      </div><div class="r-segment" id="r-segment-stay"><div class="r-gutter" id="r-gutter-stay"></div>

      </div><div class="r-segment" id="r-segment-fees"><div class="r-gutter" id="r-gutter-fees"></div>

      </div>

    </div>
</div>
HTML;

ComponentC::$comp["reserv_modal_add_main"] = <<<'HTML'
<br/>
<div class="input-group">
    <label for="m-status">Arrival Status:</label>
    <select class="form-control" id="m-status" name="m-status">
        <option value="0">Not yet arrived</option>
        <option value="1">Checked-in</option>
		<option value="2">Checked-out</option>
        <option value="3">Cancelled</option>
    </select>
</div>
<br/>
<div class="input-group">
    <label for="m-source">Booking Source:</label>
    <select class="form-control" id="m-source" name="m-source">
    </select>
</div>
<br/>
<div class="input-group">
    <label for="m-source">Additional Notes:</label>
    <textarea class="form-control" id="m-description" name="m-description" rows="3"></textarea>
    </select>
</div>
HTML;

ComponentC::$comp["reserv_modal_add_people"] = <<<'HTML'
<table id="r-tab-people">
	<tr id="th">
		<th id="p-name">Name</th>
		<th id="p-passport">Passport No</th>
		<th id="p-country">Country</th>
		<th id="p-birth">Birth Date</th>
		<th id="p-del">Delete</th>
	</tr>
</table>
<table id="r-tab-p-add">
	<tr>
		<td class="p-add"><div class="tablebtn green" id="p-add"><span class="glyphicon glyphicon-plus"></span> Add Another Person</div></td>
	</tr>
</table>
HTML;

ComponentC::$comp["reserv_modal_add_people_row"] = <<<'HTML'
	<tr dbid="0">
		<td id="p-name">
            <input id="p-i-name" type="text" placeholder="Name..." class="form-control tab-input" maxlength="64">
		</td>
		<td id="p-passport">
            <input id="p-i-passport" type="text" placeholder="Passport no..." class="form-control tab-input" maxlength="64">
		</td>
		<td id="p-country">
            <select class="form-control tab-input" id="p-i-country"></select>
		</td>
		<td id="p-birth">
			<select class="form-control tab-input" id="p-i-bday"></select><select class="form-control tab-input" id="p-i-bmon"></select><select class="form-control tab-input" id="p-i-byea"></select>
		</td>
		<td id="p-del"><span class="glyphicon glyphicon-remove" id="p-i-del"></span></td>
	</tr>
HTML;

ComponentC::$comp["reserv_modal_add_stay"] = <<<'HTML'
<div id="r-date-stay">
<select class="form-control tab-input" id="s-date-month"></select> / <select class="form-control tab-input" id="s-date-year"></select>
</div>
<div id="r-matrix-stay">
<table id="s-matrix">
	<tr>
		<td class="matrix-h"></td>
		<td class="matrix-h">01</td>
		<td class="matrix-h">02</td>
		<td class="matrix-h">03</td>
		<td class="matrix-h">04</td>
		<td class="matrix-h">05</td>
		<td class="matrix-h">06</td>
		<td class="matrix-h">07</td>
		<td class="matrix-h">08</td>
		<td class="matrix-h">09</td>
		<td class="matrix-h">10</td>
		<td class="matrix-h">11</td>
		<td class="matrix-h">12</td>
		<td class="matrix-h">13</td>
		<td class="matrix-h">14</td>
		<td class="matrix-h">15</td>
		<td class="matrix-h">16</td>
		<td class="matrix-h">17</td>
		<td class="matrix-h">18</td>
		<td class="matrix-h">19</td>
		<td class="matrix-h">20</td>
		<td class="matrix-h">21</td>
		<td class="matrix-h">22</td>
		<td class="matrix-h">23</td>
		<td class="matrix-h">24</td>
		<td class="matrix-h">25</td>
		<td class="matrix-h">26</td>
		<td class="matrix-h">27</td>
		<td class="matrix-h">28</td>
		<td class="matrix-h">29</td>
		<td class="matrix-h">30</td>
	</tr>
	<tr>
		<td class="matrix-h">101</td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
	</tr>
	<tr room="5">
		<td class="matrix-h">102</td>
		<td class="matrix-d" day="20140601"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
		<td class="matrix-d"></td>
	</tr>
</table>
</div>
<table id="r-tab-stay">
	<tr>
		<th id="s-ind">#</th>
		<th id="s-date">Date</th>
		<th id="s-room">Room</th>
		<th id="s-del">Delete</th>
	</tr>
	<tr>
		<td id="s-ind">1</td>
		<td id="s-date">12/06/2014</td>
		<td id="s-room">102</td>
		<td id="s-del"><span class="glyphicon glyphicon-remove" id="s-i-del"></span></td>
	</tr>
	<tr>
		<td id="s-ind">2</td>
		<td id="s-date">13/06/2014</td>
		<td id="s-room">102</td>
		<td id="s-del"><span class="glyphicon glyphicon-remove" id="s-i-del"></span></td>
	</tr>
	<tr>
		<td id="s-ind">3</td>
		<td id="s-date">14/06/2014</td>
		<td id="s-room">102</td>
		<td id="s-del"><span class="glyphicon glyphicon-remove" id="s-i-del"></span></td>
	</tr>
</table>
HTML;

ComponentC::$comp["reserv_modal_add_stay_row"] = <<<'HTML'
	<tr>
		<td id="s-ind"></td>
		<td id="s-date"></td>
		<td id="s-room"></td>
		<td id="s-del"><span class="glyphicon glyphicon-remove" id="s-i-del"></span></td>
	</tr>
HTML;

ComponentC::$comp["reserv_modal_add_fees"] = <<<'HTML'
<table id="r-tab-fees">
	<tr id="th">
		<th id="f-type">Type</th>
		<th id="f-description">Description</th>
		<th id="f-amount">Amount</th>
		<th id="f-currency">Currency</th>
		<th id="f-paid">Paid?</th>
		<th id="f-del">Delete</th>
	</tr>
</table>
<table id="r-tab-f-add">
	<tr>
		<td class="f-add"><div class="tablebtn green" id="f-add"><span class="glyphicon glyphicon-plus"></span> Add Another Fee</div></td>
	</tr>
</table>
HTML;

ComponentC::$comp["reserv_modal_add_fees_row"] = <<<'HTML'
	<tr dbid="0">
		<td id="f-type">
            <select class="form-control tab-input" id="f-i-type"></select>
		</td>
		<td id="f-description">
            <input id="f-i-description" type="text" placeholder="Description..." class="form-control tab-input" maxlength="128">
		</td>
		<td id="f-amount">
            <input id="f-i-amount" type="text" placeholder="Amount..." class="form-control tab-input" maxlength="9">
		</td>
		<td id="f-currency">
			<select class="form-control tab-input" id="f-i-currency"><option value="TL">TL</option><option value="$">$</option><option value="€">€</option><option value="£">£</option></select>
		</td>
		<td id="f-paid">
			<input type="checkbox" id="f-i-paid">
		</td>
		<td id="f-del"><span class="glyphicon glyphicon-remove" id="f-i-del"></span></td>
	</tr>
HTML;

/*
ComponentC::$comp["page_summary"] = <<<'HTML'
<div class="sum-segment" id="arriving">
    <div id="cap"><span class="glyphicon glyphicon-arrow-down"></span> Arriving Reservations</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-source">Source</td>
            <td class="col-person">Person</td>
        </tr>
    </table><div class="sum-date" id="yesterday"></div><table id="yesterday">

    </table><div class="sum-date" id="today"></div><table id="today">

    </table><div class="sum-date" id="tomorrow"></div><table id="tomorrow">

    </table>
</div><div class="sum-segment" id="leaving">
    <div id="cap"><span class="glyphicon glyphicon-arrow-up"></span> Leaving Reservations</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-source">Source</td>
            <td class="col-person">Person</td>
        </tr>
    </table><div class="sum-date" id="yesterday"></div><table id="yesterday">

    </table><div class="sum-date" id="today"></div><table id="today">

    </table><div class="sum-date" id="tomorrow"></div><table id="tomorrow">

    </table>
</div><br/><div class="sum-segment" id="fees">
    <div id="cap"><span class="glyphicon glyphicon-shopping-cart"></span> Unpaid Fees</div>
    <table id="header">
        <tr>
            <td class="col-room">Room</td>
            <td class="col-name">Name</td>
            <td class="col-type">Type</td>
            <td class="col-amount">Amount</td>
        </tr>
    </table>
    <table id="fees">

    </table>
</div><div class="sum-segment" id="notes">
    <div id="cap"><span class="glyphicon glyphicon-pushpin"></span> Notes</div>
</div>
HTML;

ComponentC::$comp["summary_row_arriving"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-source"></td>
            <td class="col-person"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_leaving"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-source"></td>
            <td class="col-person"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_fee"] = <<<'HTML'
        <tr class="datarow">
            <td class="col-room"></td>
            <td class="col-name"></td>
            <td class="col-type"></td>
            <td class="col-amount"></td>
        </tr>
HTML;

ComponentC::$comp["summary_row_alldone"] = <<<'HTML'
        <tr>
            <td class="col-alldone">All done!</td>
        </tr>
HTML;

ComponentC::$comp["summary_row_note"] = <<<'HTML'
    <table id="notes">
        <tr class="datarow">
            <td class="col-note"></td>
            <td class="col-action">
                <div class="tablebtn green" id="note-edit"><span class="glyphicon glyphicon-cog"></span> Edit</div>&nbsp;&nbsp;&nbsp;
                <div class="tablebtn red" id="note-delete"><span class="glyphicon glyphicon-trash"></span> Delete</div>
            </td>
        </tr>
    </table>
HTML;

ComponentC::$comp["summary_row_noteadd"] = <<<'HTML'
    <table id="add">
        <tr>
            <td class="col-noteadd"><div class="tablebtn green" id="note-add"><span class="glyphicon glyphicon-plus"></span> Add New Note</div></td>
        </tr>
    </table>
HTML;

ComponentC::$comp["summary_modal_noteadd"] = <<<'HTML'
<div class="input-group">
    <input id="new-note" name="new-note" type="text" class="form-control" placeholder="Enter new note here..." maxlength="3000">
</div>
HTML;

ComponentC::$comp["summary_modal_note_edit"] = <<<'HTML'
<div class="input-group">
    <input id="edit-note" name="edit-note" type="text" class="form-control" maxlength="3000">
</div>
HTML;

ComponentC::$comp["summary_modal_alert"] = <<<'HTML'
<div id="modal-alert" class="alert alert-danger" style="display: inline-block;"><span class="glyphicon glyphicon-warning-sign"></span>&nbsp;&nbsp;</div>
HTML;



*/












