<?php

namespace MyobAdvanced\Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use MyobAdvanced\Account;
use MyobAdvanced\Exception\InvalidCredentialsException;
use MyobAdvanced\Tests\Helpers\CookieJar;

class LoginTest extends BaseTest
{
    public function setUp(): void
    {
        parent::setUp();

        // Reset the cookie jar
        $cookieJar = new CookieJar();

        $this->myobAdvanced->setCookieJar($cookieJar);
    }

    public function testLogin()
    {
        Http::fakeSequence()->push('', 204, [
            'Set-Cookie' => [
                '.ASPXAUTH=3C0CFC1E18FE09ADB6FF4C65935A25BDA7F8ED470B1917B0C3045219B2C96670A1AADADFB1790D0AD3FCA5CABF22938CDD0E54BC7DC732233565E57C45A43228345C000A754787D63DC846C5A8C70B3BD6FE535FCB1EF4B1CFB93E2B7C10BE6170BF4A521A91C6203E17FB6B588905AB485D4EB23AF487582340B45855DA1D9B4B80717FFF7FD7DACC12E1B68568C23681AD5F41; path=/; HttpOnly',
                'UserBranch=1; path=/; secure; HttpOnly',
            ],
        ]);

        $this->myobAdvanced->login();

        Http::assertSent(function (Request $request) {
            return
                $request->url() == 'https://testing.myobadvanced.com/entity/auth/login';
        });

        $this->assertEquals(2, $this->myobAdvanced->getCookieJar()->count());
    }

    public function testFailedLogin()
    {
        $this->expectException(InvalidCredentialsException::class);

        Http::fakeSequence()->push('{
    "message": "An error has occurred.",
    "exceptionMessage": "Error: Invalid credentials. Please try again.",
    "exceptionType": "PX.Data.PXException",
    "stackTrace": "   at PX.Data.PXLogin.PX.Data.IPXLogin.LoginUser(String& userName, String password)\r\n   at PX.Api.Services.LoginService.Login(String login, String password, String company, String branch, String locale, String prefix)\r\n   at PX.Api.ContractBased.ILoginServiceExtensions.LoginForSoapApi(ILoginService loginService, IMultiFactorService multiFactorService, String login, String password, String company, String branch, String locale)\r\n   at PX.Api.ContractBased.WebApi.Controllers.AuthController.Login(Credentials credentials)\r\n   at System.Web.Http.Controllers.ReflectedHttpActionDescriptor.ActionExecutor.<>c__DisplayClass6_1.<GetExecutor>b__0(Object instance, Object[] methodParameters)\r\n   at System.Web.Http.Controllers.ReflectedHttpActionDescriptor.ExecuteAsync(HttpControllerContext controllerContext, IDictionary`2 arguments, CancellationToken cancellationToken)\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Runtime.CompilerServices.TaskAwaiter.HandleNonSuccessAndDebuggerNotification(Task task)\r\n   at System.Web.Http.Controllers.ApiControllerActionInvoker.<InvokeActionAsyncCore>d__1.MoveNext()\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Runtime.CompilerServices.TaskAwaiter.HandleNonSuccessAndDebuggerNotification(Task task)\r\n   at System.Web.Http.Filters.ActionFilterAttribute.<CallOnActionExecutedAsync>d__6.MoveNext()\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Web.Http.Filters.ActionFilterAttribute.<CallOnActionExecutedAsync>d__6.MoveNext()\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Runtime.CompilerServices.TaskAwaiter.HandleNonSuccessAndDebuggerNotification(Task task)\r\n   at System.Web.Http.Filters.ActionFilterAttribute.<ExecuteActionFilterAsyncCore>d__5.MoveNext()\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Runtime.CompilerServices.TaskAwaiter.HandleNonSuccessAndDebuggerNotification(Task task)\r\n   at System.Web.Http.Controllers.ActionFilterResult.<ExecuteAsync>d__5.MoveNext()\r\n--- End of stack trace from previous location where exception was thrown ---\r\n   at System.Runtime.ExceptionServices.ExceptionDispatchInfo.Throw()\r\n   at System.Runtime.CompilerServices.TaskAwaiter.HandleNonSuccessAndDebuggerNotification(Task task)\r\n   at System.Web.Http.Dispatcher.HttpControllerDispatcher.<SendAsync>d__15.MoveNext()"
}', 500);

        $this->myobAdvanced->login();
    }
}
