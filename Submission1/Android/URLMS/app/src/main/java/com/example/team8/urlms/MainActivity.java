package com.example.team8.urlms;

import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.text.method.ScrollingMovementMethod;
import android.view.Gravity;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

import java.text.DecimalFormat;
import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.StaffController;
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.StaffMember;
import ca.mcgill.ecse321.urlms.model.URLMS;
import ca.mcgill.ecse321.urlms.persistence.*;

import android.content.res.XmlResourceParser;
import android.widget.Toast;

import static android.R.id.message;
import static android.icu.lang.UCharacter.GraphemeClusterBreak.T;
import static android.provider.AlarmClock.EXTRA_MESSAGE;
import static com.example.team8.urlms.R.string.addMember;
import static com.example.team8.urlms.R.string.deleteAll;
import static com.example.team8.urlms.R.string.refreshButton;


//import static com.example.team8.urlms.MainActivity.load;

public class MainActivity extends AppCompatActivity {


    private URLMS urlms;
    private String fileName;


    Button staff;
    Button funding;
    Button inventory;
    Button refreshButton;
    TextView toDisplay;
    TextView appTitle;
    TextView notificationDisplay;


    Controller c = new Controller();
    StaffController sc = new StaffController();
    FundingController fc = new FundingController();

    //decimal format to 2 digits after decimal
    DecimalFormat format = new DecimalFormat("#.00");
    String notification="";
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);


        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms4.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();

        //buttons
        staff = (Button) findViewById(R.id.staffButton);
        funding = (Button) findViewById(R.id.fundingButton);
        inventory = (Button) findViewById(R.id.inventoryButton);
        refreshButton = (Button) findViewById(R.id.refreshButton);

        //text views
        toDisplay = (TextView) findViewById(R.id.toDisplay);
        appTitle = (TextView) findViewById(R.id.appTitle);
        toDisplay.setMovementMethod(new ScrollingMovementMethod());
        notificationDisplay = (TextView) findViewById(R.id.notificationDisplay);
        notificationDisplay.setVisibility(View.INVISIBLE);
        notificationDisplay.setMovementMethod(new ScrollingMovementMethod());

        /*
         *initiate all buttons
         */
        openFunding();openInventory();openStaff();setRefreshButton();

        //initiate initial account if first login
        int accountsInitiated = fc.initiateFundingAccounts();
        if(accountsInitiated == 1){
            toastMessage("Welcome back to URLMS");
        }
        else{
            toastMessage("Welcome to URLMS, initial funding accounts created.");
        }
        //get alert for critical account balances
        notifyCriticalAccount();
        if(!notification.equals("")){
            notificationDisplay.setText(notification);
            notificationDisplay.setVisibility(View.VISIBLE);
        }


    }

    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
    /*
    This methods loops through all funding accounts to check for
    any critical state (negative/critical balance level).
     */
    public void notifyCriticalAccount() {
        List<FundingAccount> accounts = fc.viewFundingAccounts();
        for (FundingAccount account : accounts) {
            if(account.getBalance()<0){
                notification = notification + account.getType() + ":    " + "$"+ format.format(account.getBalance()) + "\n";
            }

        }
        if(!notification.equals("")){
            notification = "!!!ALERT!!!"+"\n"+"NEGATIVE BALANCE:"+"\n"+"\n"+"\n" + notification;
           Toast myToast =  Toast.makeText(getApplicationContext(), notification, Toast.LENGTH_LONG);
            myToast.setGravity(Gravity.CENTER,0,0);
            myToast.show();
        }
        else{
            notification = "";
        }
    }



    //button methods
    public void openStaff(){
        staff.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
            startActivity(StaffPage.class);
            }
        });
    }    public void openFunding(){
        funding.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(FundingPage.class);
            }
        });
    }    public void openInventory(){
        inventory.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(InventoryPage.class);

            }
        });
    }
        public void setRefreshButton(){
        refreshButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                recreate();
            }
        });
    }

    public void startActivity(Class<?> cls){
        sc.save();
        Intent intent = new Intent(this,cls );
        startActivity(intent);
    }







}
