package com.example.tests;

import java.util.regex.Pattern;
import java.util.concurrent.TimeUnit;
import org.junit.*;
import static org.junit.Assert.*;
import static org.hamcrest.CoreMatchers.*;
import org.openqa.selenium.*;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.support.ui.Select;

public class UnitTests {
  private WebDriver driver;
  private String baseUrl;
  private boolean acceptNextAlert = true;
  private StringBuffer verificationErrors = new StringBuffer();

  @Before
  public void setUp() throws Exception {
    driver = new FirefoxDriver();
    baseUrl = "http://www.poliu.co.nf/";
    driver.manage().timeouts().implicitlyWait(30, TimeUnit.SECONDS);
  }

  @Test
  public void testUnitTests() throws Exception {
    driver.get(baseUrl + "/connect.php");
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*I am an address book\\.\\.\\.\r\n\r\nHear me ROAR![\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*clearing your session[\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    try {
      assertTrue(isElementPresent(By.linkText("clearing your session")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    try {
      assertTrue(isElementPresent(By.linkText("Sign in with Twitter")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.linkText("Sign in with Twitter")).click();
    driver.get(baseUrl + "/oauth/authorize?oauth_token=M9OSMwM0XeKMnkwhzsUF740ASAep6GQ8DDCwnELtuL0");
    driver.findElement(By.id("allow")).click();
    driver.findElement(By.linkText("clearing your session")).click();
    driver.findElement(By.linkText("Sign in with Twitter")).click();
    driver.findElement(By.id("allow")).click();
    try {
      assertTrue(isElementPresent(By.linkText("Sign out")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    try {
      assertTrue(isElementPresent(By.linkText("Contact")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Forbes\r\n\r\nPhone: 123\\.123\\.1234\r\nHandle: forbes\r\nFollowers: 1746792\r\n\r\n\r\n	\r\nCharles\r\n\r\nPhone: 123\\.123\\.1234\r\nHandle: reiver\r\nFollowers: 1980\r\n\r\n\r\n	\r\nTechVibes\r\n\r\nPhone: 123\\.123\\.1234\r\nHandle: techvibes\r\nFollowers: 35948\r\n\r\n\r\n	\r\n[\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.cssSelector("input.btn-medium.btn-danger")).click();
    try {
      assertEquals("Delete", driver.findElement(By.cssSelector("input.btn-medium.btn-danger")).getAttribute("value"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    try {
      assertTrue(isElementPresent(By.xpath("(//form[@action='index.php'])[2]")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.cssSelector("input.btn-medium.btn-info")).click();
    driver.findElement(By.id("edit_name_field")).clear();
    driver.findElement(By.id("edit_name_field")).sendKeys("");
    driver.findElement(By.cssSelector("input.btn-medium.btn-success")).click();
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Wow! Looks like you didn't fill in something right\\. Don't give up! [\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.id("edit_name_field")).clear();
    driver.findElement(By.id("edit_name_field")).sendKeys("Charles");
    driver.findElement(By.id("edit_phone_field")).clear();
    driver.findElement(By.id("edit_phone_field")).sendKeys("1231231214");
    driver.findElement(By.cssSelector("input.btn-medium.btn-success")).click();
    try {
      assertTrue(isElementPresent(By.id("add_submit")));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Add an entry\r\n\r\nName:\r\nPhone number:\r\nTwitter handle: [\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.id("add_submit")).click();
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Wow! Looks like you didn't fill in something right\\. Don't give up! [\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.id("add_name_field")).clear();
    driver.findElement(By.id("add_name_field")).sendKeys("Po");
    driver.findElement(By.id("add_phone_field")).clear();
    driver.findElement(By.id("add_phone_field")).sendKeys("1231231234");
    driver.findElement(By.id("add_t_handle_field")).clear();
    driver.findElement(By.id("add_t_handle_field")).sendKeys("poliu2s");
    driver.findElement(By.id("add_submit")).click();
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Po\r\n\r\nPhone: 123\\.123\\.1234\r\nHandle: poliu2s\r\nFollowers: 20 [\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
    driver.findElement(By.linkText("Sign out")).click();
    // Warning: verifyTextPresent may require manual changes
    try {
      assertTrue(driver.findElement(By.cssSelector("BODY")).getText().matches("^[\\s\\S]*Sign in with Twitter[\\s\\S]*$"));
    } catch (Error e) {
      verificationErrors.append(e.toString());
    }
  }

  @After
  public void tearDown() throws Exception {
    driver.quit();
    String verificationErrorString = verificationErrors.toString();
    if (!"".equals(verificationErrorString)) {
      fail(verificationErrorString);
    }
  }

  private boolean isElementPresent(By by) {
    try {
      driver.findElement(by);
      return true;
    } catch (NoSuchElementException e) {
      return false;
    }
  }

  private boolean isAlertPresent() {
    try {
      driver.switchTo().alert();
      return true;
    } catch (NoAlertPresentException e) {
      return false;
    }
  }

  private String closeAlertAndGetItsText() {
    try {
      Alert alert = driver.switchTo().alert();
      String alertText = alert.getText();
      if (acceptNextAlert) {
        alert.accept();
      } else {
        alert.dismiss();
      }
      return alertText;
    } finally {
      acceptNextAlert = true;
    }
  }
}
