package com.example.team8.urlms;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.Toast;

import java.util.List;

import ca.mcgill.ecse321.urlms.application.URLMSApplication;
import ca.mcgill.ecse321.urlms.controller.Controller;
import ca.mcgill.ecse321.urlms.controller.FundingController;
import ca.mcgill.ecse321.urlms.controller.InventoryController;
import ca.mcgill.ecse321.urlms.model.FundingAccount;
import ca.mcgill.ecse321.urlms.model.InventoryItem;
import ca.mcgill.ecse321.urlms.model.URLMS;
import java.text.DecimalFormat;

import static android.R.attr.format;

public class FundingListPage extends AppCompatActivity {

    private URLMS urlms;
    private String fileName;
    Controller controller = new Controller();
    InventoryController ic = new InventoryController();
    FundingController fc = new FundingController();

    //decimal format to 2 digits after decimal
    DecimalFormat format = new DecimalFormat("#.00");

    Button backButton;
    Button refreshButton;
    ListAdapter viewItemAdapter;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_funding_list_page);

        //load controller and model
        fileName = getFilesDir().getAbsolutePath() + "/urlms.xml";
        URLMSApplication.setFilename(fileName);
        urlms = URLMSApplication.getURLMS();

        Bundle b =this.getIntent().getExtras();
        final String[] fundingList = b.getStringArray("data");

        List<FundingAccount> fa = fc.viewFundingAccounts();
        final String[] fundingAccounts= new String[fa.size()];

        //intrepret bundle to array list for ListView
        for(int i =0; i<fa.size(); i++){
            fundingAccounts[i]= "Type: " + fc.viewFundingAccountType(i)+"\n" +
                    "Balance: " +String.valueOf(format.format(Double.parseDouble(fc.viewFundingAccountBalance(i))))+"\n";
        }

        //ListView creator to display list of accounts
        viewItemAdapter = new ArrayAdapter<String>(this, android.R.layout.simple_list_item_1, fundingAccounts);
        ListView buckyListView = (ListView) findViewById(R.id.buckyListView);
        buckyListView.setAdapter(viewItemAdapter);


        buckyListView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                Toast myToast= Toast.makeText(getApplicationContext(),"You have clicked on " +fundingAccounts[position],Toast.LENGTH_SHORT);
                myToast.show();
                ic.save();
                Intent intent = new Intent(getApplicationContext(),FundingAccountPage.class );
                intent.putExtra("itemPosition", position);
                finish();
                startActivity(intent);

            }
        });

        backButton = (Button) findViewById(R.id.backButton);
        refreshButton = (Button) findViewById(R.id.refreshButton);
        setBackButton();
        setRefreshButton();
    }
    //button methods
    public void setBackButton(){
        backButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {fc.save();
                finish();
            }
        });
    }
    public void startActivity(Class<?> cls){
        fc.save();
        Intent intent = new Intent(this,cls );
        startActivity(intent);
        finish();
    }
    public void setRefreshButton(){
        refreshButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                toastMessage("Refreshed.");
                recreate();
            }
        });

    }
    public void toastMessage(String message){
        Toast myToast= Toast.makeText(getApplicationContext(),message,Toast.LENGTH_SHORT);
        myToast.show();
    }
}
