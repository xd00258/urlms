package com.example.team8.urlms;

/**
 * Created by Eric Vuong on 2017-12-07.
 */

import android.support.test.espresso.assertion.ViewAssertions;
import android.support.test.rule.ActivityTestRule;
import android.support.test.runner.AndroidJUnit4;

import org.junit.Rule;
import org.junit.Test;
import org.junit.runner.RunWith;


import static android.support.test.espresso.Espresso.onData;
import static android.support.test.espresso.Espresso.onView;
import static android.support.test.espresso.action.ViewActions.click;
import static android.support.test.espresso.action.ViewActions.typeText;
import static android.support.test.espresso.matcher.ViewMatchers.isDisplayed;
import static android.support.test.espresso.matcher.ViewMatchers.withId;
import static android.support.test.espresso.matcher.ViewMatchers.withText;

@RunWith(AndroidJUnit4.class)
public class HomePageUITest {

    @Rule
    public ActivityTestRule<MainActivity> mActivityTestRule = new ActivityTestRule<MainActivity>(MainActivity.class);



    @Test
    public void test()

    {
        onView(withText("Staff")).check(ViewAssertions.matches(isDisplayed()));
        onView(withText("Funding")).check(ViewAssertions.matches(isDisplayed()));
        onView(withText("Inventory")).check(ViewAssertions.matches(isDisplayed()));
        onView(isDisplayed());

        onView(withId(R.id.staffButton)).perform(click());
        onView(withId(R.id.insertName)).perform(typeText("Eric"));
        onView(withId(R.id.insertWeeklySalary)).perform(typeText("10"));
        onView(withId(R.id.researchAssistantBox)).perform(click());
        onView(withId(R.id.backButton)).perform(click());
        onView(withId(R.id.fundingButton)).perform(click());
        onView(withId(R.id.viewFundingAccountsButton)).perform(click());
        onView(withId(R.id.backButton)).perform(click());
        onView(withId(R.id.backButton)).perform(click());
        onView(withId(R.id.inventoryButton)).perform(click());
        onView(withId(R.id.insertItemName)).perform(typeText("Oscilloscope"));
        onView(withId(R.id.insertCostItem)).perform(typeText("56.7"));
        onView(withId(R.id.viewInventoryListButton)).perform(click());


    }

}
