package ca.mcgill.ecse321.urlms.view;

import java.awt.EventQueue;

import javax.swing.JFrame;
import javax.swing.JPanel;
import javax.swing.border.EmptyBorder;

import ca.mcgill.ecse321.urlms.controller.InvalidInputException;
import ca.mcgill.ecse321.urlms.controller.StaffController;

import javax.swing.GroupLayout;
import javax.swing.GroupLayout.Alignment;
import javax.swing.JTextField;
import javax.swing.LayoutStyle.ComponentPlacement;
import javax.swing.JButton;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import javax.swing.JLabel;
import javax.swing.JScrollPane;

public class AddProgressUpdatePopOut extends JFrame {

	private JPanel contentPane;
	private JTextField txtTargetStaffMember;
	private JTextField txtDate;
	private JTextField txtDescription;
	public static StaffController controller = new StaffController();
	private JLabel lblTargetStaffMember;
	private JLabel lblDate;
	private JLabel lblDescription;
	private String error;
	private JButton btnAddProgressUpdate;
	private JButton btnClose;
	private JScrollPane scrollPane;
	private JLabel lblError;

	/**
	 * Create the frame.
	 */
	
	
	public AddProgressUpdatePopOut() {
		setResizable(false);
		setAlwaysOnTop(true);
		initComponents();
	}
	private void initComponents() {
		setTitle("Add Progress Update");
		setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
		setBounds(100, 100, 568, 320);
		contentPane = new JPanel();
		contentPane.setBorder(new EmptyBorder(5, 5, 5, 5));
		setContentPane(contentPane);
		
		txtTargetStaffMember = new JTextField();
		txtTargetStaffMember.setColumns(10);
		
		txtDate = new JTextField();
		txtDate.setColumns(10);
		
		txtDescription = new JTextField();
		txtDescription.setColumns(10);
		
		btnAddProgressUpdate = new JButton("Add Progress Update");
		btnAddProgressUpdate.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				error = "";
				
				try {
					int targetID = Integer.valueOf(txtTargetStaffMember.getText());
					String description = txtDescription.getText();
					String date = txtDate.getText();
					
					controller.addProgressByID(date, description, targetID);
				} catch (NumberFormatException e1) {
					error += "Please enter a valid ID";
				} catch (InvalidInputException e1) {
					error += e1.getMessage();
				} catch (RuntimeException e1) {
					error += e1.getMessage();
				}
				refreshData();
			}
		});
		
		lblTargetStaffMember = new JLabel("Target Staff Member ID:");
		
		lblDate = new JLabel("Date:");
		
		lblDescription = new JLabel("Description:");
		
		btnClose = new JButton("Close");
		btnClose.addActionListener(new ActionListener() {
			public void actionPerformed(ActionEvent e) {
				close();
			}
		});
		
		scrollPane = new JScrollPane();
		GroupLayout gl_contentPane = new GroupLayout(contentPane);
		gl_contentPane.setHorizontalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGroup(gl_contentPane.createParallelGroup(Alignment.LEADING)
						.addGroup(gl_contentPane.createSequentialGroup()
							.addGap(59)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING)
								.addComponent(lblDate)
								.addComponent(lblDescription))
							.addPreferredGap(ComponentPlacement.UNRELATED)
							.addGroup(gl_contentPane.createParallelGroup(Alignment.TRAILING, false)
								.addGroup(gl_contentPane.createSequentialGroup()
									.addGap(9)
									.addComponent(lblTargetStaffMember)
									.addPreferredGap(ComponentPlacement.RELATED)
									.addComponent(txtTargetStaffMember, GroupLayout.PREFERRED_SIZE, 64, GroupLayout.PREFERRED_SIZE))
								.addComponent(txtDescription, GroupLayout.DEFAULT_SIZE, 249, Short.MAX_VALUE)
								.addComponent(txtDate)))
						.addGroup(gl_contentPane.createSequentialGroup()
							.addGap(134)
							.addComponent(btnAddProgressUpdate)
							.addPreferredGap(ComponentPlacement.RELATED)
							.addComponent(btnClose)))
					.addContainerGap(GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE))
				.addGroup(Alignment.TRAILING, gl_contentPane.createSequentialGroup()
					.addContainerGap(20, Short.MAX_VALUE)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 522, GroupLayout.PREFERRED_SIZE)
					.addGap(10))
		);
		gl_contentPane.setVerticalGroup(
			gl_contentPane.createParallelGroup(Alignment.LEADING)
				.addGroup(gl_contentPane.createSequentialGroup()
					.addGap(8)
					.addComponent(scrollPane, GroupLayout.PREFERRED_SIZE, 32, GroupLayout.PREFERRED_SIZE)
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(lblTargetStaffMember)
						.addComponent(txtTargetStaffMember, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE))
					.addGap(16)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtDate, GroupLayout.PREFERRED_SIZE, GroupLayout.DEFAULT_SIZE, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblDate))
					.addPreferredGap(ComponentPlacement.RELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(txtDescription, GroupLayout.PREFERRED_SIZE, 92, GroupLayout.PREFERRED_SIZE)
						.addComponent(lblDescription))
					.addPreferredGap(ComponentPlacement.UNRELATED)
					.addGroup(gl_contentPane.createParallelGroup(Alignment.BASELINE)
						.addComponent(btnAddProgressUpdate)
						.addComponent(btnClose))
					.addContainerGap(23, Short.MAX_VALUE))
		);
		
		lblError = new JLabel("You can add some progress. Yay.");
		scrollPane.setViewportView(lblError);
		contentPane.setLayout(gl_contentPane);
	}
	
	private void refreshData(){
		if(error.length() > 0){
			lblError.setText(error);
		}
		else{
			lblError.setText("Progress update successfully added.");
		}
	}
	
	public void close() { 
		this.setVisible(false);
	    this.dispose();
	}
}
